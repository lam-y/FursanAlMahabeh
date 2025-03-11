@if (config('backpack.base.scripts') && count(config('backpack.base.scripts')))
    @foreach (config('backpack.base.scripts') as $path)
        <script type="text/javascript" src="{{ asset($path) . '?v=' . config('backpack.base.cachebusting_string') }}"></script>
    @endforeach
@endif

@if (config('backpack.base.mix_scripts') && count(config('backpack.base.mix_scripts')))
    @foreach (config('backpack.base.mix_scripts') as $path => $manifest)
        <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

@include('backpack::inc.alerts')

<!-- page script -->
<script type="text/javascript">
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function() {
        Pace.restart();
    });

    // polyfill for `startsWith` from https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/startsWith
    if (!String.prototype.startsWith) {
        Object.defineProperty(String.prototype, 'startsWith', {
            value: function(search, rawPos) {
                var pos = rawPos > 0 ? rawPos | 0 : 0;
                return this.substring(pos, pos + search.length) === search;
            }
        });
    }



    // polyfill for entries and keys from https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries#polyfill
    if (!Object.keys) Object.keys = function(o) {
        if (o !== Object(o))
            throw new TypeError('Object.keys called on a non-object');
        var k = [],
            p;
        for (p in o)
            if (Object.prototype.hasOwnProperty.call(o, p)) k.push(p);
        return k;
    }

    if (!Object.entries) {
        Object.entries = function(obj) {
            var ownProps = Object.keys(obj),
                i = ownProps.length,
                resArray = new Array(i); // preallocate the Array
            while (i--)
                resArray[i] = [ownProps[i], obj[ownProps[i]]];
            return resArray;
        };
    }

    // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    {{-- Enable deep link to tab --}}
    var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
    location.hash && activeTab && activeTab.tab('show');
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        location.hash = e.target.hash.replace("#tab_", "#");
    });
</script>


<script>
    $(document).ready(function() {
        if (window.location.pathname.includes('/admin/member/create') ||
            window.location.pathname.includes('/admin/member/edit')) {
            // تنفيذ الوظيفة عند تغيير member_type_id
            $('[name="member_type_id"]').on('change select2:select', toggleFieldsBasedOnMemberType);

            // استدعاء الدالة عند تغيير قيمة الحقل 'grade_id'
            $('[name="grade_id"]').on('change', toggleFieldsBasedOnGrade)

            // تشغيل الوظيفة عند تحميل الصفحة بالكامل
            toggleFieldsBasedOnMemberType();
            toggleFieldsBasedOnGrade();
        }
    });

    // ----------------------------------------------------------------
    function toggleFieldsBasedOnMemberType() {
        let selectedValue = $('[name="member_type_id"]').val();
        let toggleWrapper = $('[name="promoted"]').closest('.toggle');
        let promotedCheckbox = $('[name="promoted"]')[0];

        // الحقول التي سيتم تعطيلها أو تفعيلها
        let fieldsToToggle = [
            '[name="branch_id"]',
            '[name="totem"]',
            '[name="totem_name"]',
            '[name="publicBadges[]"]'
        ];

        // في حالة member_type_id = null أو ""
        if (!selectedValue) {
            promotedCheckbox.checked = false;
            toggleWrapper.removeClass('btn-primary').addClass('btn-default off');
            promotedCheckbox.disabled = true;
            disableFields(fieldsToToggle);
        }
        // في حالة member_type_id = "1"
        else if (selectedValue == "1") {
            promotedCheckbox.checked = false;
            toggleWrapper.removeClass('btn-default off').addClass('btn-primary');
            promotedCheckbox.disabled = false;
            disableFields(fieldsToToggle);
        }
        // في حالة member_type_id = "2"
        else if (selectedValue == "2") {
            promotedCheckbox.checked = true;
            toggleWrapper.removeClass('btn-default off').addClass('btn-primary');
            promotedCheckbox.disabled = true;
            enableFields(fieldsToToggle);
        }
    }

    // ----------------------------------------------------------------
    function disableFields(fields) {
        fields.forEach(field => {
            let $element = $(field);
            if ($element.is(':checkbox')) {
                $element.prop('checked', false);
            } else if ($element.is('select')) {
                $element.val(null).trigger('change');
            } else {
                $element.val('');
            }
            $element.prop('disabled', true).closest('.form-group').addClass('disabled');
        });
    }

    // ----------------------------------------------------------------
    function enableFields(fields) {
        fields.forEach(field => {
            $(field).prop('disabled', false).closest('.form-group').removeClass('disabled');
        });
    }

    // ----------------------------------------------------------------
    function toggleFieldsBasedOnGrade() {
        let selectedGrade = $('[name="grade_id"]').val();

        // الحقول التي يجب إظهارها أو إخفاؤها
        let fieldsToToggle = [
            '[name="foulard"]',
            '[name="junior_degree"]',
            '[name="second_degree"]',
            '[name="branchBadges[]"]',
            '[name="hobbyBadges[]"]',
            '[name="promoted"]',
            '[name="member_type_id"]',
            '[name="branch_id"]',
            '[name="totem"]',
            '[name="totem_name"]',
            '[name="publicBadges[]"]'
        ];

        if (!selectedGrade || selectedGrade !== "10") {
            hideFields(fieldsToToggle);
        } else {
            showFields(fieldsToToggle);
        }
    }

    // ----------------------------------------------------------------
    function hideFields(fields) {
        fields.forEach(field => {
            let $element = $(field);
            let $wrapper = $element.closest('.form-group');

            // إعادة تعيين القيم بناءً على نوع الحقل
            if ($element.is(':checkbox')) {
                $element.prop('checked', false).trigger('change');
            } else if ($element.is('select')) {
                $element.val(null).trigger('change');
            } else {
                $element.val('');
            }

            $wrapper.css({
                'visibility': 'hidden',
                'position': 'absolute'
            });
        });
    }

    // ----------------------------------------------------------------
    function showFields(fields) {
        fields.forEach(field => {
            $(field).closest('.form-group').css({
                'visibility': 'visible',
                'position': 'relative'
            });
        });
    }
</script>
