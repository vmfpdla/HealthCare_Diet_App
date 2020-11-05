var date_arr = new Array();
var muscle_arr = new Array();
var dailyinbodyarray = document.getElementById("dailyinbodyarray");
dailyinbodyarray = dailyinbodyarray.innerHTML;
dailyinbodyarray = JSON.parse(dailyinbodyarray);

for(var i=0;i<5;i++)
{
	if(muscle_arr[i]===undefined) muscle_arr[i]=0;
}

dailyinbodyarray.sort(function(a, b) { // 오름차순
    return a.inbody_day < b.inbody_day ? -1 : a.inbody_day > b.inbody_day ? 1 : 0;
});

for(var i=0;i<5;i++)
{
	date_arr[i] = dailyinbodyarray[i].inbody_day;
	muscle_arr[i]=dailyinbodyarray[i].inbody_muscle;
}

var ctx = document.getElementById('inbodyMuscle').getContext('2d');
var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: {
			labels: date_arr,
			datasets: [
				{ label: '근육량',
					backgroundColor: 'transparent',
					borderColor: 'Green',
					data: muscle_arr
				}
			]
		}, // 옵션
		options: {
			legend: {
				labels: {
					fontColor: "Green",
					fontSize: 18
				}
			}


		} });
