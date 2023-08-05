@props(['userRegistrationKeys'])

<div class="modal fade" id="viewUserKeys" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-confirm modal-lg">
        <div class="modal-content p-0 m-0">

            <table class="table table-bordered table-striped">
                <tr>
                    {{-- Display the "Good" headers first --}}
                    <th scope="col" class="bg-primary text-white">User Type</th>
                    <th scope="col" class="bg-primary text-white">Province</th>
                    <th scope="col" class="bg-primary text-white">Division</th>
                    <th scope="col" class="bg-primary text-white">UserKey</th>
                    <th scope="col" class="bg-primary text-white">Status</th>
                </tr>
                @php
                    $userTypeNames = [
                        1 => 'Regional Director',
                        2 => 'Regional Planning Officer',
                        3 => 'Provincial Director',
                        4 => 'Provincial Planning Officer',
                        5 => 'Division Chief',
                    ];
                    $userProvinces = [
                        1 => 'Bukidnon',
                        2 => 'Lanao Del Norte',
                        3 => 'Misamis Oriental',
                        4 => 'Misamis Occidental',
                        5 => 'Camiguin',
                    ];
                    $userDivisions = [
                        1 => 'Business Development Division',
                        2 => 'Consumer Protection Division',
                        3 => 'Finance Administrative Division'
                    ];

                    // Sort the user registration keys based on the "Status" column
                    $sortedKeys = $userRegistrationKeys->sortBy('Status', SORT_NATURAL|SORT_FLAG_CASE)->values();
                @endphp
                @foreach ($sortedKeys as $userRegistrationKey)
                    <tr>
                        {{-- Use the "Good" headers to retrieve the data --}}
                        <td>{{ $userTypeNames[$userRegistrationKey->user_type_ID] ?? 'N/A' }}</td>
                        <td>{{ $userProvinces[$userRegistrationKey->province_ID] ?? 'N/A' }}</td>
                        <td>{{ $userDivisions[$userRegistrationKey->division_ID] ?? 'N/A'}}</td>
                        <td>{{ $userRegistrationKey->registration_key }}</td>
                        <td
                            class="{{ $userRegistrationKey->Status === 'Taken' ? 'bg-danger' : 'bg-success' }} text-white">
                            {{ $userRegistrationKey->Status }}</td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>
