<h1>Congratulations, you imported the file {{ $report->filename }}</h1>

<dl>
    <dt>Total Imported</dt>
    <dd>{{ $report->total() }}</dd>
    <dt>Successfully imported</dt>
    <dd> {{ $report->successful }}</dd>
    <dt>Registration failures</dt>
    <dd> {{ $report->failed_reg }}</dd>
    <dt>Price failures</dt>
    <dd>{{ $report->failed_price }}</dd>
    <dt>Failed images</dt>
    <dd>{{ $report->failed_images }}</dd>
</dl>

