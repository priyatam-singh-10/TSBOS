@php
    $address = !empty($student->address) ? json_decode($student->address, true) : [];

    // Fetch all enrolled courses for this student
    $enrollments = App\Models\Enrollment::where('user_id', $student->id)->get();
@endphp

<table class="table table-bordered table-striped align-middle">
    <tr>
        <th width="30%">{{ get_phrase('Name') }}</th>
        <td>{{ $student->name }}</td>
    </tr>

    {{-- <tr>
        <th>{{ get_phrase('Email') }}</th>
        <td>{{ $student->email }}</td>
    </tr> --}}

    <tr>
        <th>{{ get_phrase('Phone') }}</th>
        <td>{{ $student->phone ?? '-' }}</td>
    </tr>
    <tr>
        <th>{{ get_phrase('Password') }}</th>
        <td>{{ $student->plain_password ?? '-' }}</td>
    </tr>
    @php
        $country = DB::table('countries1')
            ->where('id', $address['country_id'] ?? null)
            ->value('name');

        $state = DB::table('states')
            ->where('id', $address['state_id'] ?? null)
            ->value('name');

        $city = DB::table('cities')
            ->where('id', $address['city_id'] ?? null)
            ->value('name');
    @endphp

    <tr>
        <th>{{ get_phrase('Country') }}</th>
        <td>{{ $country ?? '-' }}</td>
    </tr>

    <tr>
        <th>{{ get_phrase('State') }}</th>
        <td>{{ $state ?? '-' }}</td>
    </tr>

    <tr>
        <th>{{ get_phrase('City') }}</th>
        <td>{{ $city ?? '-' }}</td>
    </tr>

    <!--<tr>-->
    <!--    <th>{{ get_phrase('About') }}</th>-->
    <!--    <td>{{ $student->about ?? '-' }}</td>-->
    <!--</tr>-->

    {{-- Enrolled Courses --}}
    {{-- <tr>
        <th>{{ get_phrase('Enrolled Courses') }}</th>
        <td>
            @if ($enrollments->count() > 0)
                <ul class="mb-0">
                    @foreach ($enrollments as $enrollment)
                        @php
                            $course = App\Models\Course::find($enrollment->course_id);
                        @endphp
                        @if ($course)
                            <li>
                                <strong>{{ $course->title }}</strong>
                                @if (!empty($enrollment->created_at))
                                    - <small>{{ $enrollment->created_at->format('d M Y') }}</small>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            @else
                {{ '-' }}
            @endif
        </td>
    </tr> --}}

    <tr>
        <th>{{ get_phrase('Total Courses') }}</th>
        <td>
            {{ $enrollments->count() }} {{ get_phrase('Courses') }}
        </td>
    </tr>
</table>
