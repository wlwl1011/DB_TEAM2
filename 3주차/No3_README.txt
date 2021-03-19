온도가 COVID19 확진자 수에 영향을 주는 지를 확인하기 위하여 Weather 테이블의 avg_temp를 기준으로 영역별 확진자 수를 count하여 data를 추출함.
이때 집단감염으로 인한 확진자들은 온도가 COVID19 확진자 수에 영향을 주는지를 알아보는 데 불필요한 데이터라고 판단되어 모든 경우(집단감염자와 아닌 자들이 섞인 경우)와 집단감염이 아닌 경우를 나누어 count한 결과를 볼 수 있도록 option을 설정함.

count(avg_temp)는 해당 영역의 확진자 수를 보여주는 column이며,
MIN(avg_temp)는 해당 영역의 가장 낮은 온도를 보여주는 column이고,
MAX(avg_temp)는 해당 영역의 가장 높은 온도를 보여주는 column이다.

->MIN(avg_temp)와 MAX(avg_temp)로 영역(온도의 범위)을 알 수 있음.