var date_arr = new Array();
var bmi_arr = new Array();
var dailyinbodyarray = document.getElementById("dailyinbodyarray");
dailyinbodyarray = dailyinbodyarray.innerHTML;
dailyinbodyarray = JSON.parse(dailyinbodyarray);

for(var i=0;i<5;i++)
{
	if(bmi_arr[i]===undefined) bmi_arr[i]=0;
}

dailyinbodyarray.sort(function(a, b) { // 오름차순
    return a.inbody_day < b.inbody_day ? -1 : a.inbody_day > b.inbody_day ? 1 : 0;
});

if(dailyinbodyarray.length<5){
	   for(var i=1;i<5;i++) date_arr[i] = '';
}
for(var i=0;i<dailyinbodyarray.length;i++)
{
	date_arr[i] = dailyinbodyarray[i].inbody_day;
	bmi_arr[i]=dailyinbodyarray[i].inbody_bmi;
}

var ctx = document.getElementById('inbodyBmi').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: { labels: date_arr, datasets: [{ label: 'BMI', backgroundColor: 'transparent', borderColor: 'red', data: bmi_arr }] }, // 옵션
		options: {
			legend: {
				labels: {
					fontColor: "black",
					fontSize: 30
				}
			},

			scales: {
				xAxes: [{
					ticks:{
						fontColor : 'rgba(12, 13, 13, 1)',
						fontSize : 25
					},

				}],
				yAxes: [{
					ticks: {
						beginAtZero:false,
						fontSize : 30
					}
				}]
			},

		} });
