var ctx = document.getElementById('inbodyFat').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택 
			type: 'line', // 챠트를 그릴 데이타 
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '체지방률', backgroundColor: 'transparent', borderColor: 'Blue', data: [23.4, 23, 23.3, 22.9, 22.9, 22.7, 22.4] }] }, // 옵션 
		options: {

			legend: {
				labels: {
					fontColor: "blue",
					fontSize: 18
				}
			}
		} }); 