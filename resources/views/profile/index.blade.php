<x-layout_landingPage>
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-6 text-blue-900">Data Perkembangan Anak</h2>
            
            <div class="max-w-3xl mx-auto">
                <!-- Progress Chart -->
                <div id="progressChart" class="mb-8" style="height: 300px;"></div>

                <!-- Skills Progress -->
                <div class="space-y-6 mt-8">
                    <div class="skill-item">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Mewarnai</span>
                            <span>7%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-400 rounded-full h-2" style="width: 7%"></div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Menggunting</span>
                            <span>7%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-400 rounded-full h-2" style="width: 7%"></div>
                        </div>
                    </div>

                    <div class="skill-item">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Merance</span>
                            <span>7%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-400 rounded-full h-2" style="width: 7%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Highcharts.chart('progressChart', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                custom: {},
                events: {
                    render() {
                        const chart = this,
                            series = chart.series[0];
                        let customLabel = chart.options.chart.custom.label;

                        if (!customLabel) {
                            customLabel = chart.options.chart.custom.label =
                                chart.renderer.label(
                                    '<div style="text-align: center">Total Progress<br/>' +
                                    '<strong>21%</strong></div>'
                                )
                                .css({
                                    color: '#000',
                                    textAlign: 'center'
                                })
                                .add();
                        }

                        const x = series.center[0] + chart.plotLeft,
                            y = series.center[1] + chart.plotTop -
                            (customLabel.attr('height') / 2);

                        customLabel.attr({
                            x,
                            y
                        });
                        
                        customLabel.css({
                            fontSize: `${series.center[2] / 8}px`
                        });
                    }
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    innerSize: '75%',
                    borderRadius: 8,
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#3B82F6', '#E5E7EB']
                }
            },
            series: [{
                name: 'Progress',
                data: [
                    ['Progress', 21],
                    ['Remaining', 79]
                ]
            }]
        });
    });
    </script>
</x-layout_landingPage>