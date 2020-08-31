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
# driver = webdriver.PhantomJS(executable_path="C://phantomjs.exe")
# driver = webdriver.Chrome(executable_path="C://chromedriver.exe",chrome_options=options)

city = {"基隆市":"10017","臺北市":"63","新北市":"65","桃園市":"68","新竹市":"10018","新竹縣":"10004","苗栗縣":"10005","臺中市":"66","彰化縣":"10007","南投縣":"10008","雲林縣":"10009","嘉義市":"10020","嘉義縣":"10010","臺南市":"67","高雄市":"64","屏東縣":"10013","宜蘭縣":"10002","花蓮縣":"10015","臺東縣":"10014","澎湖縣":"10016","金門縣":"09020","連江縣":"09007"}


for key,value in city.items():
    url = "https://www.cwb.gov.tw/V8/C/W/County/County.html?CID="+value
    driver.get(url)
    try:
        WebDriverWait(driver,30).until(EC.presence_of_element_located((By.ID,'table_top')))
    finally:
        content = BeautifulSoup(driver.page_source,"html.parser")

        html = content.find('div',class_='sevenDaysReport')

        sql = "select * from getHtml"
        cursor.execute(sql)

        if cursor.rowcount == 0:
            sql = "insert into getHtml(city,html) values(%s,%s)"
            cursor.execute(sql,[key,str(html)])
            conn.commit()
        else:
            sql = "update getHtml set html = %s where city = %s"
            cursor.execute(sql,[str(html),key])
            conn.commit()


driver.close()
conn.close()
cursor.close()