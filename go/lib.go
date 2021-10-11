package main

import (
	"io"
	"io/ioutil"
	"os"
)

func file_get_contents(filename string) ([]byte, error) {
	file, err := os.Open(filename)
	if err != nil {
		return []byte{}, err
	}
	defer file.Close()

	// 循环读取文件
	var content []byte
	var tmp = make([]byte, 128)
	for {
		n, err := file.Read(tmp)
		if err == io.EOF {
			//fmt.Println("文件读完了")
			break
		}
		if err != nil {
			//fmt.Println("read file failed, err:", err)
			return []byte{}, err
		}
		content = append(content, tmp[:n]...)
	}

	return []byte{}, nil
}

func file_put_contents(filename string, content string) error {
	return ioutil.WriteFile(filename, []byte(content), 0644)
}
