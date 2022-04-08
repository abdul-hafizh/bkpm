<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">@lang('label.note_revision')</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body p-0">
        @php
            $notes = \SimpleCMS\ActivityLog\Models\Activity::inLog('LOG_SURVEY_NOTE_REVISION')->latest()->with(['causer'])->where('subject_id', $survey->id)->limit(10)->get();
        @endphp
        <table class="table table-sm">
            <thead>
            <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 64%;">Message</th>
                <th style="width: 15%;">By</th>
                <th style="width: 19%;">Created At</th>
            </tr>
            </thead>
            <tbody>
            @if ($notes->count())
                @foreach ($notes as $idx => $note)
                    <tr>
                        <td>{{ $idx+1 }}</td>
                        <td>{{ $note->description }}</td>
                        <td>{{ ($note->causer ? $note->causer->name : '-') }}</td>
                        <td>
                            <span class="f-s-15">{{ formatDate($note->created_at, 1,1,1,1) }}</span>
                            <br/>
                            <small>{{ $note->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="4"><i>Data empty</i></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
