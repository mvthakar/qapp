<?php $time = time(); ?>
<!-- jQuery -->
<script src="<?= urlOf("admin/plugins/jquery/jquery.min.js") ?>?<?= $time ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= urlOf("admin/plugins/jquery-ui/jquery-ui.min.js") ?>?<?= $time ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge("uibutton", $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= urlOf("admin/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>?<?= $time ?>"></script>
<!-- ChartJS -->
<script src="<?= urlOf("admin/plugins/chart.js/Chart.min.js") ?>?<?= $time ?>"></script>
<!-- Sparkline -->
<script src="<?= urlOf("admin/plugins/sparklines/sparkline.js") ?>?<?= $time ?>"></script>
<!-- JQVMap -->
<script src="<?= urlOf("admin/plugins/jqvmap/jquery.vmap.min.js") ?>?<?= $time ?>"></script>
<script src="<?= urlOf("admin/plugins/jqvmap/maps/jquery.vmap.usa.js") ?>?<?= $time ?>"></script>
<!-- jQuery Knob Chart -->
<?php $time = time(); ?>
<script src="<?= urlOf("admin/plugins/jquery-knob/jquery.knob.min.js") ?>?<?= $time ?>"></script>
<!-- daterangepicker -->
<script src="<?= urlOf("admin/plugins/moment/moment.min.js") ?>?<?= $time ?>"></script>
<script src="<?= urlOf("admin/plugins/daterangepicker/daterangepicker.js") ?>?<?= $time ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= urlOf("admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") ?>?<?= $time ?>"></script>
<!-- Summernote -->
<script src="<?= urlOf("admin/plugins/summernote/summernote-bs4.min.js") ?>?<?= $time ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= urlOf("admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") ?>?<?= $time ?>"></script>
<!-- AdminLTE App -->
<script src="<?= urlOf("admin/js/adminlte.js") ?>?<?= $time ?>"></script>
<!-- PopperJS -->
<script src="<?= urlOf("admin/js/popper.min.js") ?>?<?= $time ?>"></script>
<script src="<?= urlOf("admin/js/app.js") ?>?<?= $time ?>"></script>
