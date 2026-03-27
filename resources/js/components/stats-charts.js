// Initializes the donut chart (spending by category) and the bar chart (6-month trend).
// Data is passed via data-* attributes on #donutChart and #trendChart elements.

export const initStatsCharts = () => {
    const isDark    = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#9ca3af' : '#6b7280';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

    // Donut chart
    const donutEl = document.querySelector('#donutChart');
    if (donutEl) {
        const spending = JSON.parse(donutEl.dataset.spending);
        const currency = donutEl.dataset.currency;
        const colors   = JSON.parse(donutEl.dataset.colors);
        const height   = parseInt(donutEl.dataset.height) || 280;

        if (spending.length > 0) {
            new ApexCharts(donutEl, {
                series: spending.map(c => parseFloat(c.amount)),
                labels: spending.map(c => c.emoji + ' ' + c.name),
                colors: colors.slice(0, spending.length),
                chart: {
                    type: 'donut',
                    height,
                    fontFamily: 'Outfit, sans-serif',
                    toolbar: { show: false },
                },
                plotOptions: { pie: { donut: { size: '65%' } } },
                dataLabels: { enabled: false },
                legend: {
                    position: 'bottom',
                    fontFamily: 'Outfit, sans-serif',
                    labels: { colors: textColor },
                },
                tooltip: {
                    y: { formatter: val => val.toFixed(2) + ' ' + currency }
                },
            }).render();
        }
    }

    // Bar chart — trend
    const trendEl = document.querySelector('#trendChart');
    if (trendEl) {
        const trend         = JSON.parse(trendEl.dataset.trend);
        const currency      = trendEl.dataset.currency;
        const incomeLabel   = trendEl.dataset.incomeLabel;
        const expensesLabel = trendEl.dataset.expensesLabel;
        const height        = parseInt(trendEl.dataset.height) || 280;

        new ApexCharts(trendEl, {
            series: [
                { name: incomeLabel,   data: trend.map(m => parseFloat(m.income)) },
                { name: expensesLabel, data: trend.map(m => parseFloat(m.expenses)) },
            ],
            colors: ['#43e97b', '#fa709a'],
            chart: {
                type: 'bar',
                height,
                fontFamily: 'Outfit, sans-serif',
                toolbar: { show: false },
            },
            plotOptions: {
                bar: { horizontal: false, columnWidth: '45%', borderRadius: 4, borderRadiusApplication: 'end' }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: trend.map(m => m.label),
                labels: { style: { colors: textColor } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: { labels: { style: { colors: textColor } } },
            legend: {
                position: 'top',
                fontFamily: 'Outfit, sans-serif',
                labels: { colors: textColor },
            },
            grid: { borderColor: gridColor },
            tooltip: {
                y: { formatter: val => val.toFixed(2) + ' ' + currency }
            },
        }).render();
    }
};

export default initStatsCharts;
