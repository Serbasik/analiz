
<div id="page-wrapper" style="margin-left: 0px;">
    <div class="header">
        <h1 class="page-header">
            Анализ данных №1
        </h1>


    </div>
    <div id="page-inner">

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-action">
                        <div style="text-align: center;">
                            <?php foreach ($god as $item):?>
                                <a style="margin: 5px 10px 5px 0" class="waves-effect waves-light btn" id="<?= $item['id']?>"><?= $item['id']?></a>
                            <?php endforeach;?>
                        </div>
                        <div id="map"></div>
                    </div>
                    <div class="card-content">


                        <div class="clearBoth"><br></div>
                        <script>
                            $('.btn').on('click', function () {
                                var year = ($(this).attr('id'));
                                $.ajax({
                                    url: '/site/getdata',
                                    type: 'POST',
                                    data: {year: year},
                                    dataType: 'json',
                                    beforeSend: function(request) { return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content')); },
                                    success: function (res) {
                                        if (res && res != 0) {
                                            alert (year);

                                        }

                                    },
                                    error: function () {
                                        alert('ERROR');
                                    }
                                });
                                return false;
                            });
                        </script>
