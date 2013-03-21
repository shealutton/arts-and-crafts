#!/usr/bin/python
import psycopg2

conn = psycopg2.connect("dbname=time user=time host=192.168.40.22 password=50eclipse")
cursor = conn.cursor()
cursor.execute("SELECT t0, t1 FROM cme_candi ORDER BY seq DESC LIMIT 3600") # 3600 = 1HR
data = cursor.fetchall()

for row in data:
    print row[1] - row[0]
