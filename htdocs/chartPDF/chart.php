<body>
    <div class="container pt-5">
        <h1>Membuat Grafik dengan PHP dan MySQLI</h1>
        <div class="chart-container" style="position: relative; height:40vh; width:80vw">
            <canvas id="myChart"></canvas>
        </div>
        <button id="downloadPdf">Download PDF</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        <?php
        include 'koneksi.php';
        $query = "SELECT jurusan, COUNT(*) AS jml_mahasiswa FROM mahasiswa GROUP BY jurusan;";
        $result = mysqli_query($koneksi, $query);
        while ($data = mysqli_fetch_array($result)) {
            $jurusan[] = $data['jurusan'];
            $jumlah[] = $data['jml_mahasiswa'];
        }
        ?>

        const ctx = document.getElementById("myChart").getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jurusan); ?>,
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: <?php echo json_encode($jumlah); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 71, 1)',
                        'rgba(9, 31, 242, 0.8)',
                        'rgba(255, 128, 6, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 71, 1)',
                        'rgba(9, 31, 242, 0.8)',
                        'rgba(255, 128, 6, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                    },
                },
            },
        });

        document.getElementById('downloadPdf').addEventListener('click', function () {
            const { jsPDF } = window.jsPDF;
            const pdf = new jsPDF();
            const canvas = document.getElementById("myChart");
            const imgData = canvas.toDataURL("image/png");
            pdf.addImage(imgData, 'PNG', 10, 10, 180, 100);
            pdf.save('chart.pdf');
        });
    </script>
</body>
</html>