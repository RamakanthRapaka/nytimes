<x-mail::message>
# Top Three Books

<x-mail::table>
| List Name       | Book Title         | Author  | Rank | Weeks On List | Image | Links To Buy  |
| ------------- |:-------------:| --------:|:-------------:|:-------------:|:--------:|:--------:|
@foreach ($mailData['results'] as $result)
@php
$buy_links = json_decode($result['buy_links'], true);
@endphp
| {{ $result['list_name'] }} | {{ $result['title'] }} | {{ $result['author'] }} | {{ $result['book_rank'] }} | {{ $result['weeks_on_list'] }} | ![DemoImage]({{ $result['image'] }}) | @foreach ($buy_links as $buy_link) [{{ $buy_link['name'] }}]({{ $buy_link['url'] }}) @endforeach |
@endforeach
</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
