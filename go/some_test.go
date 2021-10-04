package main

import (
	"fmt"
	"math/rand"
	"testing"
	"time"
)

func TestRandom(t *testing.T) {
	fmt.Println("---- testRandom ----")
	rand.Seed(time.Now().UnixNano())

	for i := 0; i < 1000; i++ {
		randomIntStart := rand.Intn(899999)
		randomIntEnd := randomIntStart + 100000
		fmt.Println(randomIntStart, randomIntEnd)
	}
}
