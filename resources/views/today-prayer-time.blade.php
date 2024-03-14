<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .dc-clear:before,
        .dc-clear:after {
            display: table;
            content: " ";
        }

        .dc-clear:after {
            clear: both;
        }

        #prayerTimesContainer {}

        #prayerTimesContainer .s3-heading {
            text-align: center;
        }

        #prayerTimesContainer table {
            width: 100%;
        }

        #prayerTimesContainer table .prayer-name{}
        #prayerTimesContainer table .prayer-azan{}
        #prayerTimesContainer table .prayer-time{}

        .friday-prayers {
            margin: 10px auto;
            text-align: center;
            border: solid 1px black;
        }

        .friday-prayers .friday-prayer {
            float: left;
            width: 50%;
            text-align: center;
        }

        .friday-prayers .friday-prayer .khuthbah-name {}

        .friday-prayers .friday-prayer .khuthbah-time {
            font-weight: bold;
            margin-bottom:20px;
        }

        .friday-prayers .friday-prayer .friday-prayer-name {}

        .friday-prayers .friday-prayer .friday-prayer-time {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="loadingIndicator" style="display: none;">Loading...</div>
    <div id="prayerTimesContainer" style="display: none;">
        <div class="s3-heading">
            <h2>Jamaat Timings</h2>
            <h5>Today: <span id="todayDate"></span> | Sunrise at <span id="sunrise"></span></h5>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Prayer Name</th>
                    <th>Adhan Time</th>
                    <th>Prayer Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Fajr</td>
                    <td id="fajr_azan"></td>
                    <td id="fajr"></td>
                </tr>
                <tr>
                    <td>Zuhr</td>
                    <td id="zuhr_azan"></td>
                    <td id="zuhr"></td>
                </tr>
                <tr>
                    <td>Asr</td>
                    <td id="asr_azan"></td>
                    <td id="asr"></td>
                </tr>
                <tr>
                    <td>Maghrib</td>
                    <td id="maghrib_azan"></td>
                    <td id="maghrib"></td>
                </tr>
                <tr>
                    <td>Isha</td>
                    <td id="isha_azan"></td>
                    <td id="isha"></td>
                </tr>
            </tbody>
        </table>

        <div class="friday-prayers dc-clear">
            <div class="friday-prayer">
                <div class="khuthbah-name">Friday First Khuthbah Time</div>
                <div class="khuthbah-time" id="first_jumma_khutba"></div>
                <div class="friday-prayer-name">Friday First Prayer Time</div>
                <div class="friday-prayer-time" id="first_jumma"></div>
            </div>
            <div class="friday-prayer">
                <div class="khuthbah-name">Friday Second Khuthbah Time</div>
                <div class="khuthbah-time" id="second_jumma_khutba"></div>
                <div class="friday-prayer-name">Friday Second Prayer Time</div>
                <div class="friday-prayer-time" id="second_jumma"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script>
        // Show loading indicator
        $('#loadingIndicator').show();
        // Make an AJAX request to fetch the data
        $.ajax({
            url: '/api/today-prayer-time', // Adjust the API end point
            method: 'GET',
            success: function(response) {
                // Hide loading indicator
                $('#loadingIndicator').hide();
                $('#prayerTimesContainer').show();

                // Extract data from the response
                var data = response.data;

                // Set today's date
                $('#todayDate').text(data.date);

                // Set Fajr time
                $('#fajr_azan').text(data.fajr);
                $('#fajr').text(data.fajr);

                // Set Sunrise time
                $('#sunrise').text(data.sunrise);

                // Set Zuhr time
                $('#zuhr_azan').text(data.zuhr);
                $('#zuhr').text(data.zuhr);

                // Set Asr time
                $('#asr_azan').text(data.asr);
                $('#asr').text(data.asr);

                // Set Maghrib time
                $('#maghrib_azan').text(data.maghrib);
                $('#maghrib').text(data.maghrib);

                // Set Isha time
                $('#isha_azan').text(data.isha);
                $('#isha').text(data.isha);

                // Set First Friday Prayer
                $('#first_jumma_khutba').text(data.first_jumma_khutba);
                $('#first_jumma').text(data.first_jumma);

                // Set Second Friday Prayer
                $('#second_jumma_khutba').text(data.second_jumma_khutba);
                $('#second_jumma').text(data.second_jumma);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    </script>
</body>

</html>
