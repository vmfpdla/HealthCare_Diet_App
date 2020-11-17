var date_arr = new Array();
var weight_arr = new Array();
var dailyinbodyarray = document.getElementById("dailyinbodyarray");
dailyinbodyarray = dailyinbodyarray.innerHTML;
dailyinbodyarray = JSON.parse(dailyinbodyarray);

for(var i=0;i<5;i++)
{
	if(weight_arr[i]===undefined) weight_arr[i]=0;
}

dailyinbodyarray.sort(function(a, b) { // 오름차순
    return a.inbody_day < b.inbody_day ? -1 : a.inbody_day > b.inbody_day ? 1 : 0;
});

for(var i=0;i<5;i++)
{
	date_arr[i] = dailyinbodyarray[i].inbody_day;
	weight_arr[i]=dailyinbodyarray[i].inbody_weight;
}

var ctx = document.getElementById('inbodyKg').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: { labels: date_arr, datasets: [{ label: '체중', backgroundColor: 'transparent', borderColor: 'red', data: weight_arr }] }, // 옵션
		options: {
			legend: {
				labels: {
					fontColor: "red",
					fontSize: 18
				}
			}

		} });
