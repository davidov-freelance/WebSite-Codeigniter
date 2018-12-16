<!-- BEGIN PAGE HEAD -->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Статистика лидов</h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD -->

<!-- BEGIN PAGE CONTENT INNER -->
<div class="row margin-top-10">

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp"><?=getNormalMoney($stat_today, false);?></h3>
                    <small>сегодня</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp"><?= getNormalMoney($stat_week, false);?></h3>
                    <small>за неделю</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 100%;" class="progress-bar progress-bar-success blue-sharp"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft"><?= getNormalMoney($stat_all, false);?></h3>
                    <small>Всего</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 100%;" class="progress-bar progress-bar-success purple-soft"></span>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="/app/admin/pages/scripts/index3.js" type="text/javascript"></script>