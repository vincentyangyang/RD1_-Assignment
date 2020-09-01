import requests
from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

import pymysql
conn = pymysql.connect(host='127.0.0.1',user='root',password='root',database='meteorological',charset='utf8')
cursor = conn.cursor()


options = Options()
# options.add_argument('--headless')
# options.add_argument('--disable-gpu')

driver = webdriver.Chrome(executable_path="/Users/admin/Documents/chromedriver",chrome_options=options)
# driver = webdriver.Chrome(executable_path="C://chromedriver.exe",chrome_options=options)


def updateRainfall():
    url = "https://www.cwb.gov.tw/V8/C/P/Rainfall/Rainfall_Hour.html?ID=22"
    driver.get(url)

    try:
        WebDriverWait(driver,30).until(EC.presence_of_element_located((By.ID,'Rainfall_MOD')))
    finally:
        sql = "show tables where Tables_in_meteorological = 'rainfall'"
        cursor.execute(sql)
        
        if (cursor.rowcount == 0):
            sql = """create table rainfall(
                rId int primary key auto_increment,
                city varchar(10) not null,
                station varchar(10) not null,
                hour varchar(10) not null,
                day varchar(10) not null
                )ENGINE=InnoDB DEFAULT CHARSET=utf8
               """
            cursor.execute(sql)

            insertSQL()
        else:
            sql = "drop table rainfall"
            cursor.execute(sql)

            sql = """create table rainfall(
                rId int primary key auto_increment,
                city varchar(10) not null,
                station varchar(10) not null,
                hour varchar(10) not null,
                day varchar(10) not null
                )ENGINE=InnoDB DEFAULT CHARSET=utf8
               """
            cursor.execute(sql)

            insertSQL()


def insertSQL():
    content = driver.find_elements_by_css_selector('#Rainfall_MOD tr')
    i = 1
    for tr in content:
        print(i)
        i += 1

        td = tr.find_elements_by_css_selector('td')
        name = tr.find_elements_by_css_selector('th')
        font = tr.find_elements_by_css_selector('font')


        if(font[0].text == ""): break

        city = (td[0].text)[0:3]

        station = name[0].text

        if (font[0].text == '-'): hour = "0"
        elif(font[0].text == 'X'): hour = "無資料"
        else: hour = font[0].text

        if (font[24].text == '-'): day = "0"
        elif(font[24].text == 'X'): day = "無資料"
        else: day = font[24].text


        sql = "insert into rainfall(city,station,hour,day) values(%s,%s,%s,%s)"
        cursor.execute(sql,(city,station,hour,day))
        conn.commit()


updateRainfall() 


driver.close()
cursor.close()
conn.close()