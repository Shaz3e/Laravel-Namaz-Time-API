<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #prayerTimesContainer {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .s3-heading {}

        .s3-heading h2 {}

        .s3-heading h4 {}

        .s3-prayer-timings {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border-bottom: solid 1px rgba(0, 0, 0, 0.1);
            padding-bottom: 5px;
        }

        .s3-prayer-timings .s3-prayer-name {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .s3-prayer-timings .s3-prayer-time {
            font-size: 1.5rem;
            font-weight: 300;
        }
    </style>
</head>

<body>
    <div id="prayerTimesContainer" style="display: none;">
        <div class="s3-heading">
            <h2>Jamaat Timings</h2>
            <h4 id="todayDate"></h4>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Fajr</div>
            <div class="s3-prayer-time" id="fajr"></div>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Sunrise</div>
            <div class="s3-prayer-time" id="sunrise"></div>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Zuhr</div>
            <div class="s3-prayer-time" id="zuhr"></div>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Asr</div>
            <div class="s3-prayer-time" id="asr"></div>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Maghrib</div>
            <div class="s3-prayer-time" id="maghrib"></div>
        </div>
        <div class="s3-prayer-timings">
            <div class="s3-prayer-name">Isha</div>
            <div class="s3-prayer-time" id="isha"></div>
        </div>
    </div>
    <div id="loadingIndicator" style="display: none;">Loading...</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        // Show loading indicator
        $('#loadingIndicator').show();
        // Make an AJAX request to fetch the data
        $.ajax({
            url: '/api/today-prayer-time', // Adjust the API end point
            method: 'GET',
            success: function (response) {
                // Hide loading indicator
                $('#loadingIndicator').hide();
                $('#prayerTimesContainer').show();

                // Extract data from the response
                var data = response.data;

                // Set today's date
                $('#todayDate').text(data.date);

                // Set Fajr time
                $('#fajr').text(data.fajr);

                // Set Sunrise time
                $('#sunrise').text(data.sunrise);

                // Set Zuhr time
                $('#zuhr').text(data.zuhr);

                // Set Asr time
                $('#asr').text(data.asr);

                // Set Maghrib time
                $('#maghrib').text(data.maghrib);

                // Set Isha time
                $('#isha').text(data.isha);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    </script>
</body>

</html>