<x-layouts.app :title="__('FedEx Holidays')">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Shipping Holidays')}}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Manage shipping holidays') }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    #
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    <div class="flex items-center">
                        Name
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    <div class="flex items-center">
                        Date
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    <div class="flex items-center">
                        Action 
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($holidays as $index => $holiday)
            <tr class="bg-neutral-primary-soft border-b  border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    {{$index+1}}
                </th>
                <td class="px-6 py-4">
                    {{$holiday->label}}
                </td>
                <td class="px-6 py-4">
                    {{$holiday->value}}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('fedex.delete-holiday', $holiday->id) }}" class="font-medium text-fg-brand hover:underline">Delete</a>
                </td>
            </tr>
            @endforeach
            <tr class="bg-neutral-primary-soft">
                <form action="{{ route('fedex.add-holiday') }}" method="POST">
                {{ csrf_field() }}
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    
                </th>
                <td class="px-6 py-4">
                    <x-forms.input label="Holiday Name" name="label" type="text" value="" />
                </td>
                <td class="px-6 py-4">
                    <x-forms.input label="Holiday Date" name="value" type="date" value="" />
                </td>
                <td class="px-6 py-4 text-right">
                    <x-button type="primary">Add Holiday</x-button>
                </td>
                </form>
            </tr>
        </tbody>
    </table>
        </div>
</div> 
</x-layouts.app>
