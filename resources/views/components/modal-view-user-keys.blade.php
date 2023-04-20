@props(['userRegistrationKeys'])

<div class="modal fade" id="viewUserKeys" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content p-0 m-0">

            {{-- <ul>
                    <li>{{ $userRegistrationKey->registration_key }}</li>
                </ul> --}}
            <table class="table table-bordered table-striped">
                <tr>
                    <th scope="col" class="bg-primary text-white">UserKey</th>
                    <th scope="col" class="bg-primary text-white">Status</th>
                       <th scope="col" class="bg-primary text-white">User ID</th>
                    <th scope="col" class="bg-primary text-white">Division ID</th>
                </tr>
                @foreach ($userRegistrationKeys ?? [] as $userRegistrationKey)
                    <tr>

                        <td>{{ $userRegistrationKey->registration_key }}</td>
                        <td>{{ $userRegistrationKey->Status}}</td>
                         <td>{{ $userRegistrationKey->user_ID}}</td>
                        <td>{{ $userRegistrationKey->division_ID}}</td>
                    </tr>
                @endforeach
            </table>


        </div>
    </div>
</div>
