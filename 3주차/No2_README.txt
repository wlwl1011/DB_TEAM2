- 모든 PHP파일의 option에는 all value를 출력하는 all value option이 있음.

- 단, PatientInfo와 Weather 테이블에는 각각 5000여개, 2500여개의 데이터가 있어 모두를 출력하도록 했을 때,
  전송되는 데이터의 양이 너무 많아 사이트가 동작을 멈추는 경우가 있어 all value를 출력할 때에는 limit 100으로 제한을 걸어둠.



1) PatientInfo
    confirmed_date를 기준으로 월(month)를 선택하면 선택한 월에 해당하는 confirmed_date를 모두 출력하도록 함.
    월(month)별 확진자의 수를 추출해내면 COVID19가 계절의 영향을 받는지에 대한 데이터를 얻을 수 있을 것이라 생각하여 confirmed_date를 기준으로 data를 출력함.

2) Case
    infection_group를 기준으로 집단감염인지 아닌지를 선택하여 데이터를 출력하도록 함.
    집단감염의 경우에는 날씨의 영향보다는 집단의 영향이 더 크기 때문에, 집단감염을 제외한 데이터들을 뽑아냄. 이 후 이 데이터들로 COVID19와 온도(날씨)의 상관관계를 밝힐 수 있을 것이라 생각하여 infection_group를 기준으로 data를 출력함.

3) Region
    province를 기준으로 지역을 선택하면 지역에 해당하는 모든 데이터를 출력하도록함.
    지역별 확진자의 수를 추출해내면 지역의 특징(날씨, 지형, 혹은 사람들의 동선 등)과 COVID19의 연관성을 알 수 있지 않을까 하여 province를 기준으로 data를 출력함.

4) Weather
    avg_temp를 기준으로 영역(기온의 범위)을 선택하여 해당하는 영역의 avg_temp를 모두 출력하도록 함.
    avg_temp가 그 날의 평균 기온이고 기온에 따라 날짜를 분류하여 그 날의 확진자 수를 알아낼 수 있다면 이 데이터들로 COVID19와 온도(날씨)의 상관관계를 밝힐 수 있을 것이라 생각하여 avg_temp를 기준으로 data를 출력함.