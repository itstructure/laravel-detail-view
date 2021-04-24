@php
    /** @var Illuminate\Database\Eloquent\Model $model */
    /** @var \Itstructure\DetailView\Rows\BaseRow[] $rowObjects */
@endphp

@if($title)
    <h2>{!! $title !!}</h2>
@endif

<table {!! $detailObj->buildHtmlAttributes() !!}>
    @if($showHead == true)
    <thead>
        <tr>
            <th {!! $captionColumnHead->buildHtmlAttributes() !!}>{{ $captionColumnHead->getLabel() }}</th>
            <th {!! $valueColumnHead->buildHtmlAttributes() !!}>{{ $valueColumnHead->getLabel() }}</th>
        </tr>
    </thead>
    @endif
    <tbody>
        @foreach($rowObjects as $rowObj)
            <tr {!! $rowObj->buildHtmlAttributes() !!}>
                <td>{{ $rowObj->getLabel() }}</td>
                <td>{!! $rowObj->render($model) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
