package main

import (
	"errors"
	"fmt"
	"math/rand"
	"net/http"
	"regexp"
	"time"

	"github.com/gin-gonic/gin"
	_ "github.com/go-sql-driver/mysql"
)

type CaptchaData struct {
	Vcode int    `json:"vcode"`
	Phone string `json:"phone"`
}

type LoginResult struct {
	Token string `json:"token"`
}

func handleGetLoginCaptcha(c *gin.Context) {
	phone := c.PostForm("phone")
	captcha, error := getLoginCaptcha(phone)

	if error != nil {
		//println(error)
		c.JSON(http.StatusOK, gin.H{
			"code":    400,
			"message": error.Error(),
		})
		return
	}

	db, err := getDB()
	if err != nil {
		println(err.Error())
		c.JSON(http.StatusOK, gin.H{
			"code":    500,
			"message": "获取失败",
		})
		return
	}

	sqlStr := "insert into sms_captcha(type, phone, code, status, created_at, updated_at)"
	sqlStr += "values (?,?,?,?,?,?)"
	nowTime := time.Now().Format("2006-01-02 15:04:05")
	_, err = db.Exec(sqlStr, "login", phone, captcha.Vcode, 0, nowTime, nowTime)
	if err != nil {
		fmt.Printf("insert failed, err:%v\n", err)
		c.JSON(http.StatusOK, gin.H{
			"code":    501,
			"message": "获取失败",
		})
		return
	}
	// lastInsertId, err := ret.LastInsertId() // 新插入数据的id
	// if err != nil {
	// 	fmt.Printf("get lastinsert ID failed, err:%v\n", err)
	// 	return
	// }

	c.JSON(http.StatusOK, gin.H{
		"code":    0,
		"message": "success",
		"debug":   captcha,
	})
}

func handleLogin(c *gin.Context) {
	var loginResult LoginResult
	phone := c.PostForm("phone")
	vcode := c.PostForm("code")

	if !checkPhone(phone) {
		//return loginResult, errors.New("请输入正确的手机号码")
		c.JSON(http.StatusOK, gin.H{
			"code":    400,
			"message": "请输入正确的手机号码",
		})
		return
	}

	if len(vcode) < 6 {
		//return loginResult, errors.New("请输入正确的手机号码")
		c.JSON(http.StatusOK, gin.H{
			"code":    400,
			"message": "请输入正确的手机验证码",
		})
		return
	}

	db, err := getDB()
	if err != nil {
		println(err.Error())
		c.JSON(http.StatusOK, gin.H{
			"code":    500,
			"message": "登录失败",
		})
		return
	}

	var captcha SmsCaptcha

	sqlStr := "select id,code from sms_captcha where type=? and phone=? and status=0 order by id desc limit 1"
	err = db.QueryRow(sqlStr, "login", phone).Scan(&captcha.ID, &captcha.Code)
	if err != nil {
		fmt.Printf("scan failed, err:%v\n", err)
		c.JSON(http.StatusOK, gin.H{
			"code":    501,
			"message": "验证码错误，登录失败",
		})
		return
	}

	if vcode != captcha.Code {
		c.JSON(http.StatusOK, gin.H{
			"code":    502,
			"message": "验证码错误，登录失败",
		})
		return
	}

	nowTime := time.Now().Format("2006-01-02 15:04:05")

	sqlStr = "update sms_captcha set status=?,updated_at=? where id=?"
	_, err = db.Exec(sqlStr, -1, nowTime, captcha.ID)
	if err != nil {
		fmt.Printf("update failed, err:%v\n", err)
		c.JSON(http.StatusOK, gin.H{
			"code":    5022,
			"message": "验证码错误，登录失败",
		})
		return
	}

	var user User
	sqlStr = "select id,phone from user where phone=? and status=0 order by id desc limit 1"
	err = db.QueryRow(sqlStr, phone).Scan(&user.ID, &user.Phone)
	if err != nil {
		fmt.Printf("query row and scan failed, err:%v\n", err)
		sqlStr = "insert into user(phone, status, created_at, updated_at)"
		sqlStr += "values (?,?,?,?)"
		ret, err := db.Exec(sqlStr, phone, 0, nowTime, nowTime)
		if err != nil {
			c.JSON(http.StatusOK, gin.H{
				"code":    503,
				"message": "登录失败: 创建用户失败",
			})
			return
		}
		theID, err := ret.LastInsertId() // 新插入数据的id
		if err != nil {
			fmt.Printf("get lastinsert ID failed, err:%v\n", err)
			c.JSON(http.StatusOK, gin.H{
				"code":    503,
				"message": "登录失败: 创建用户失败",
			})
			return
		}
		user.ID = theID
	}

	rand.Seed(time.Now().UnixNano())
	loginResult.Token = randomString(32)

	sqlStr = "update user set token=?,last_login_at=? where id=?"
	ret, err := db.Exec(sqlStr, loginResult.Token, nowTime, user.ID)
	if err != nil {
		fmt.Printf("update failed, err:%v\n", err)
		c.JSON(http.StatusOK, gin.H{
			"code":    503,
			"message": "登录失败: 创建token失败",
		})
		return
	}
	n, err := ret.RowsAffected() // 操作影响的行数
	if err != nil || n <= 0 {
		fmt.Printf("get RowsAffected failed, err:%v\n", err)
		c.JSON(http.StatusOK, gin.H{
			"code":    504,
			"message": "登录失败: 创建token失败",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"code":    0,
		"message": "success",
		"data":    loginResult,
	})
}

func checkPhone(phone string) bool {
	//解析正则表达式，如果成功返回解释器
	reg := regexp.MustCompile(`^1\d{10}$`)
	return reg.MatchString(phone)
}

func getLoginCaptcha(phone string) (CaptchaData, error) {
	var captcha CaptchaData
	if !checkPhone(phone) {
		//fmt.Println("getLoginCaptcha", phone, " is invalid phone number\n")
		return captcha, errors.New("请输入正确的手机号码")
	}

	rand.Seed(time.Now().UnixNano())
	captcha.Vcode = rand.Intn(899999) + 100000
	captcha.Phone = phone
	return captcha, nil
}

func randomInt(min int, max int) int {
	return min + rand.Intn(max-min)
}

func randomString(len int) string {
	bytes := make([]byte, len)
	for i := 0; i < len; i++ {
		bytes[i] = byte(randomInt(65, 90))
	}
	return string(bytes)
}
