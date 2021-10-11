package main

import (
	"fmt"
	"net/http"
	"os"
	"strconv"

	"github.com/gin-gonic/gin"

	//"github.com/gin-gonic/autotls"
	_ "github.com/go-sql-driver/mysql"
)

func main() {

	pid := os.Getpid()
	fmt.Println("pid:", pid)
	savePidfile(pid, "./api-demo.pid")

	router := gin.Default()

	router.GET("/", func(c *gin.Context) {
		c.JSON(http.StatusOK, gin.H{
			"code":    0,
			"message": "welcome api-demo",
		})
	})

	router.GET("/ping", func(c *gin.Context) {
		c.JSON(http.StatusOK, gin.H{
			"message": "pong",
		})
	})

	router.GET("/test", func(c *gin.Context) {
		c.String(http.StatusOK, "test 123")
	})

	router.POST("/api/login-captcha", handleGetLoginCaptcha)
	router.POST("/api/login", handleLogin)

	router.Run("127.0.0.1:8001")
}

func savePidfile(pid int, filename string) error {
	return file_put_contents(filename, strconv.Itoa(pid))
}
