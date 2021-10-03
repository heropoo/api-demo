package main

import (
	//"log"

	"net/http"

	"github.com/gin-gonic/gin"

	//"github.com/gin-gonic/autotls"
	_ "github.com/go-sql-driver/mysql"
)

func main() {
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

	router.POST("/api/login-captcha", handleGetLoginCaptcha)
	router.POST("/api/login", handleLogin)

	router.Run(":8001") // listen on 0.0.0.0:8000
}
