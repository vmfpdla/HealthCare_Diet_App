// 우선 컨텍스트를 가져옵니다. 
				var ctx = document.getElementById("Kg").getContext('2d');
/*
	- Chart를 생성하면서, 
	- ctx를 첫번째 argument로 넘겨주고, 
	- 두번째 argument로 그림을 그릴때 필요한 요소들을 모두 넘겨줍니다. 
	*/
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'],
			datasets: [{
				label: 'Daily Kg',
				data: [65, 65.4, 64.5, 64.7, 64.3, 64.6,64.3],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)'
				],
				borderWidth: 1
			}]
		},
		options: {

			legend: {
				labels: {
					fontColor: "red",
					fontSize: 18
				}
			},
						maintainAspectRatio: true, // default value. false일 경우 포함된 div의 크기에 맞춰서 그려짐.
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:false
								}
							}]
						}
					}
				});
	
