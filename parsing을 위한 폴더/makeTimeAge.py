# -*- coding: utf-8 -*-
import pymysql
import csv
import pandas as pd
import sys

#mysql server 연결, port 및 host 주의!
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root',
                        password='Eh4693227!',
                        db='K_COVID19',
                        charset='utf8')

# Connection 으로부터 Cursor 생성
cursor = conn.cursor()

kname=sys.argv[1]
data = pd.read_csv(kname)

confirmed_date = data['confirmed_date']
deceased_date = data['deceased_date']

age_data = data['age']
age_num = ['0s', '10s','20s','30s','40s','50s','60s','70s','80s','90s','100s']
age = {}
for i in list(age_num):
    if i in age.keys():
        continue
    else:
        age[i] = []

for ind in age.keys():
    cdate_dic = {}
    for i, date in enumerate(list(confirmed_date)):
        if age_data[i] != ind:
            continue
        if date in cdate_dic.keys():
            cdate_dic[date] = cdate_dic[date] + 1
        else:
            cdate_dic[date] = 1

    ddate_dic = {}
    for i, date in enumerate(list(deceased_date)):
        if age_data[i] != ind:
            continue
        if date in ddate_dic.keys():
            ddate_dic[date] = ddate_dic[date] + 1
        else:
            ddate_dic[date] = 1


    age[ind].append(cdate_dic)
    age[ind].append(ddate_dic)



date = []
total_confirmed = []
total_deceased = []
i = 0

for ind in age.keys():
    total_confirmed.insert(i, 0)
    total_deceased.insert(i,0)
    i = i+1


aname = sys.argv[2]
with open(aname, 'r') as file:
    file_read = csv.reader(file)

    # Use column 1(date), 2(test), 3(negative)
    # index = column - 1
    col_list = {
        'date' :0,
        'test' :1,
        'negative' : 2}

    for i,line in enumerate(file_read):

        #Skip first line
        if not i:
            continue

        # checking duplicate case_id & checking case_id == "NULL"
        if (line[col_list['date']] in date) or (line[col_list['date']] == "NULL") :
            continue
        else:
            date.append(line[col_list['date']])

        #make sql data & query
        sql_data = []
        #"NULL" -> None (String -> null)
        for idx in col_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            sql_data.append(line[idx])

        op = 0
        for ind in age.keys():
            sql_data = []
            sql_data.append(line[col_list['date']])
            sql_data.append(ind)

            if line[col_list['date']] in age[ind][0].keys():
                total_confirmed[op] = total_confirmed[op] + age[ind][0][line[col_list['date']]]
            sql_data.append(total_confirmed[op])
            if line[col_list['date']] in age[ind][1].keys():
                total_deceased[op] = total_deceased[op] + age[ind][1][line[col_list['date']]]
            sql_data.append(total_deceased[op])

            op = op + 1

        #Make query & execute
        query = """INSERT INTO `timeage`(date, age, confirmed, deceased) VALUES (%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)

        #for debug
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to timeageInfo"%(line[col_list['date']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['date']],e))
            break

conn.commit()
cursor.close()
