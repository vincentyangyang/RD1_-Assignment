import pymysql
conn = pymysql.connect(host='127.0.0.1',user='root',password='root',database='Online_Shop',charset='utf8')
cursor = conn.cursor()


sql = "select * from customers"
    
cursor.execute(sql)
rows = cursor.fetchall()

for row in rows:
    print(row)