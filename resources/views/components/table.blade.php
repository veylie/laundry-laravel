<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
  <div class="max-w-full overflow-x-auto">
    <table class="min-w-full">
      <thead>
        <tr class="border-b border-gray-100 dark:border-gray-800">
          @if($withNumbering)
            <th class="px-5 py-3 sm:px-6">
              <p
                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
              >No</p>
            </th>
          @endif

          @foreach($headers as $header)
            <th class="px-5 py-3 sm:px-6">
              <p
                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
              >{{ ucfirst(str_replace('_',' ',$header)) }} </p>
              
            </th>
          @endforeach

          @if($actionComponent)
          
            <th class="px-5 py-3 sm:px-6">
              <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400" >
                Action
              </p>
            </th>
          @endif
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @foreach($rows as $index => $row)
          <tr >
            @if($withNumbering)
              <td class="px-5 py-4 sm:px-6">
              <div class="flex justify-center items-c">
                 <p class="text-gray-800 dark:text-white/90">
               {{ $index + 1 }}
               </p>
              </div>
              </td>
            @endif

            @foreach($headers as $header)
              <td class="px-5 py-4 sm:px-6">
                <div class="flex justify-center items-center">
                  <p class="text-gray-800  dark:text-white/90">

                    {{ data_get($row, $header) }}
                  </p>
                </div>
              </td>
            @endforeach

            @if($actionComponent)
              <td class="px-5 py-4 sm:px-6">
                <div class="flex justify-center items-center">
                  {{-- Render dynamic component dan pass row --}}
                  @if ($routeName == 'orders')
                  <x-dynamic-component :component="$actionComponent" :type="$routeName" :routeName="$routeName" :row="$row" />
                   @else
                   <x-dynamic-component :component="$actionComponent" :routeName="$routeName" :row="$row" />
                 @endif
                </div>
              </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
