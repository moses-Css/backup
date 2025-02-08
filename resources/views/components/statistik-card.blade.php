@props (['title'=> 'Total Foto', 'count' =>'0', 'icon' =>'' ])

    <div class="flex items-center justify-center">
        <div class="bg-neutralGray2 rounded-xl p-4 flex items-center space-x-4">
            <div class="bg-primaryLight rounded-full p-2">
                {!! $icon !!}
            </div>
            <div>
                <div class="text-neutralDark font-medium whitespace-nowrap text-sm">{{$title}}</div>
                <div class="text-neutralGray">{{number_format($count)}}</div>
            </div>
        </div>
    </div>