<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($patients as $patient)
            <tr>
                <td>
                    <a href="{{ route('records.show', $patient->id) }}">
                        {{ $patient->fname }} {{ $patient->mname }} {{ $patient->lname }}
                    </a>
                </td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->phone_number }}</td>
                <td>{{ $patient->home_address }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $patients->links() }}
