package main

import (
	"encoding/json"
	"fmt"
	"io/ioutil"
	"os"

	"gopkg.in/yaml.v2"
)

type ConfigStruct struct {
	AppUrl string         `yaml:"app_url"`
	DB     DBConfigStruct `yaml:"db"`
}

type DBConfigStruct struct {
	Host     string `yaml:"host"`
	Port     int    `yaml:"port"`
	Username string `yaml:"username"`
	Password string `yaml:"password"`
	DBName   string `yaml:"dbname"`
}

func getConfig(filename string) (*ConfigStruct, error) {
	var config ConfigStruct
	content, err := ioutil.ReadFile(filename)
	if err != nil {
		fmt.Println("Read yaml file failed, err:", err)
		return &config, err
	}
	//fmt.Println(string(content))

	err = yaml.Unmarshal([]byte(content), &config)
	if err != nil {
		fmt.Println("Create yaml struct failed, err:", err)
		return &config, err
	}

	return &config, nil
}

func LoadConfig(filename string) (*ConfigStruct, error) {
	configFile, err := os.Open(filename)

	if err != nil {
		return nil, fmt.Errorf("Unable to read configuration file %s", filename)
	}

	config := new(ConfigStruct)

	decoder := json.NewDecoder(configFile)
	err = decoder.Decode(&config)
	if err != nil {
		return nil, fmt.Errorf("Unable to parse configuration file %s", filename)
	}

	return config, nil
}
