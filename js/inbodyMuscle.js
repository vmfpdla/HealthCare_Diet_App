var ctx = document.getElementById('inbodyMuscle').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택 
			type: 'line', // 챠트를 그릴 데이타 
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '근육량', backgroundColor: 'transparent', borderColor: 'Green', data: [32.1, 32.3, 32.4, 32.4, 32.2, 33, 33.3] }] }, // 옵션 
		options: {
			legend: {
				labels: {
					fontColor: "Green",
					fontSize: 18
				}
			}


		} }); 