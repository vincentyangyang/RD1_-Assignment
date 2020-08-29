import requests
from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
import time

options = Options()
# options.add_argument('--headless')
# options.add_argument('--disable-gpu')

# driver = webdriver.Chrome(executable_path="/Users/admin/Documents/chromedriver",chrome_options=options)
# driver = webdriver.PhantomJS(executable_path="C://phantomjs.exe")
driver = webdriver.Chrome(executable_path="C://chromedriver.exe",chrome_options=options)


url = "https://www.cwb.gov.tw/V8/C/W/County/County.html?CID=66"
driver.get(url)
try:
    WebDriverWait(driver,30).until(EC.presence_of_element_located((By.ID,'table_top')))
finally:
    content = BeautifulSoup(driver.page_source,"html.parser")

    html = content.find('div',class_='sevenDaysReport')


    print(html)
    driver.close()