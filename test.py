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

url = "https://www.cwb.gov.tw/V8/C/P/Rainfall/Rainfall_Hour.html?ID=1"

options = Options()
options.add_argument('--headless')
options.add_argument('--disable-gpu')

driver = webdriver.Chrome(executable_path="/Users/admin/Documents/chromedriver",chrome_options=options)
driver.get(url);

try:
    WebDriverWait(driver,30).until(EC.presence_of_element_located((By.ID,'Rainfall_MOD')))
finally:
    content = driver.find_elements_by_css_selector('#Rainfall_MOD tr')
    i=1
    for tr in content:
        name = tr.find_elements_by_css_selector('th')
        font = tr.find_elements_by_css_selector('font')

        if(font[0].text == ""): break


        station = name[0].text
        if (font[0].text == '-'): hour = "無雨"
        else: hour = font[0].text

        if (font[24].text == '-'): day = "無雨"
        else: day = font[24].text

        print(station)
        print(hour)
        print(day)
        print('-'*30)

    #     sql = "insert into rainfall(city,station,hour,day) values(%s,%s,%s,%s)"
    #     cursor.execute(sql,("臺北",station,hour,day))
    #     conn.commit()

    # cursor.close()
