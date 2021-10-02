package main

import (
	"errors"
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

	_, err := getDB()
	if err != nil {
		println(err.Error())
		c.JSON(http.StatusOK, gin.H{
			"code":    500,
			"message": "获取失败",
		})
		return
	}

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

	rand.Seed(time.Now().UnixNano())
	loginResult.Token = randomString(32)
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

	captcha.Vcode = rand.Intn(99999) + 100000
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
