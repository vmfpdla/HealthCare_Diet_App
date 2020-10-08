var ctx = document.getElementById('inbodyKg').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택 
			type: 'line', // 챠트를 그릴 데이타 
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '체중', backgroundColor: 'transparent', borderColor: 'red', data: [65, 65.4, 64.5, 64.7, 64.3, 64.6,64.3] }] }, // 옵션 
		options: {
			legend: {
				labels: {
					fontColor: "red",
					fontSize: 18
				}
			}

		} }); 