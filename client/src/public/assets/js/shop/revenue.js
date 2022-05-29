let chart = null;

async function getShopRevenue(year = new Date().getFullYear()) {
	let revenues = Array(12).fill(0);
	const promises = [];

	for (let i = 1; i <= 12; ++i) {
		promises.push(
			fetch(
				`${ORDER_SERVICE_API_URL}/revenue-by-month?shopId=${SHOP_ID}&month=${i}&year=${year}`,
			)
				.then((apiRes) => {
					if (apiRes.status === 200) {
						return apiRes.json();
					}
				})
				.then((data) => (revenues[i - 1] = data)),
		);
	}

	await Promise.all(promises);
	return revenues.map((r) => r / 1_000_000);
}

const renderChart = async (year = new Date().getFullYear()) => {
	const revenues = await getShopRevenue(year);

	const chartData = {
		labels: Array(12)
			.fill(0)
			.map((_, i) => `T${i + 1}`),
		datasets: [
			{
				label: '',
				data: revenues,
				fill: false,
				borderColor: '#11254b',
				tension: 0.1,
			},
		],
	};

	const options = {
		type: 'line',
		data: chartData,
		options: {
			plugins: {
				title: {
					display: true,
					text: `Doanh thu cửa hàng vào năm ${year}`,
					font: { size: 18 },
					color: '#ff5500',
				},
				legend: {
					display: false,
				},
				tooltip: {
					callbacks: {
						label: function (context) {
							return new Intl.NumberFormat('vi-VN', {
								style: 'currency',
								currency: 'VND',
							}).format(Number(context.raw) * 1_000_000);
						},
					},
				},
			},
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						callback: function (value, index, ticks) {
							return value + ' tr';
						},
					},
				},
			},
		},
	};

	const ctx = document.getElementById('chart').getContext('2d');
	if (chart) {
		chart.destroy();
		chart = null;
	}
	chart = new Chart(ctx, options);
};

function renderYearOptions() {
	let xml = '';
	const year = new Date().getFullYear();
	for (let i = 0; i < 10; ++i) {
		if (i === 0) {
			xml += `<option value='${year - i}' selected>${year - i}</option>`;
		} else {
			xml += `<option value='${year - i}'>${year - i}</option>`;
		}
	}
	$('#year').html(xml);
}

jQuery(async function () {
	renderYearOptions();
	renderChart(new Date().getFullYear());
	$('#year').on('change', function () {
		const year = Number($(this).val());
		renderChart(year);
	});
});
