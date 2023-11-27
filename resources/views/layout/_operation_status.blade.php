
@if(Session::has('success'))
<script type="text/javascript">
  toastr.success("{{ Session::get('success') }}")
</script>

@endif
@if(Session::has('error'))
<script type="text/javascript">
  toastr.error("{{ Session::get('error') }}")
</script>
@endif