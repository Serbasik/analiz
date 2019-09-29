<script src="/regions2.js" type="text/javascript"></script>
<script src="/grad_color.js" type="text/javascript"></script>

<div id="page-wrapper" style="margin-left: 0px;">
    <div class="header">
        <h3 class="page-header">
            <b>МЛАДЕНЧЕСКАЯ СМЕРТНОСТЬ ПО СУБЪЕКТАМ РОССИЙСКОЙ ФЕДЕРАЦИИ</b>
        </h3>
        <p style="margin-left: 20px; color: red">Целевой показатель Программы развития перинатариальных центров в Российской Федерации (утвержденной распоряжением Правительства,
            Российской Федерации от 9 декабря 2013г. N2302-р):<br/><b> 6,1 случая на 1000 детей, родившихся живыми (к 2017 году)</b></p>


    </div>
    <div id="page-inner">

        <div class="row">
              <div class="col-md-12">
                <div class="card">
                    <div class="card-action">
                        <div style="text-align: center;">
                            <?php foreach ($result as $item):?>
                                <a <?php if (empty($item['dataExists'])):?> disabled="" <?php endif;?> style="margin: 5px 10px 5px 0" class="waves-effect waves-light btn" id="<?= $item['year']?>"><?= $item['year']?></a>
                            <?php endforeach;?>
                        </div>
                        <div id="map"></div>
                        <p class="col-lg-3" style="margin-top: 15px">
                            <input name="group1" type="radio" id="test1">
                            <label for="test1">Детская смертность</label>
                        </p>
                        <p class="col-lg-2" style="margin-top: 15px">
                            <input name="group1" type="radio" id="test2">
                            <label for="test2">Рождаемость</label>
                        </p>
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
                                    beforeSend: function(request) {
                                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                    },
                                    success: function (res) {
                                        if (res && res != 0) {
                                           //alert ("op");
                                            updateData(res);
                                        }

                                    },
                                    error: function () {
                                        alert('ERROR');
                                    }
                                });
                                return false;
                            });
                        </script>
