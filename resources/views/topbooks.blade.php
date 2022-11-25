@component('mail::message')
    # {{ $mailData['title'] }}

    @component('mail::table')
        | List Name | Book Title | Author | Rank | Weeks On List | Image | Links To Buy |
        |:------: |:----------- |:--------: |:------: |:----------- |:--------: |:--------: |
        @foreach ($mailData['results'] as $result)
        $buy_links = json_decode($result['buy_links'], true);
        | {{ $result['list_name'] }} | {{ $result['title'] }} | {{ $result['author'] }} | {{ $result['book_rank'] }} | {{ $result['weeks_on_list'] }} |  <img src="{{ $result['image'] }}"> | @foreach ($buy_links as $buy_link) <a href="google.com">the link</a> @endforeach |
        @endforeach
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
