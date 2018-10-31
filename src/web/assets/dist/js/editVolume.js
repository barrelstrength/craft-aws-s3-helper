var $s3HelperAccessKeyIdInput = $('.s3-helper-key-id'),
    $s3HelperSecretAccessKeyInput = $('.s3-helper-secret-key'),
    $s3HelperBucketSelect = $('.s3-helper-bucket-select > select'),
    $s3HelperRefreshBucketsBtn = $('.s3-helper-refresh-buckets'),
    $s3HelperRefreshBucketsSpinner = $s3HelperRefreshBucketsBtn.parent().next().children(),
    $s3HelperRegion = $('.s3-helper-region'),
    refreshingS3Buckets = false;

$s3HelperRefreshBucketsBtn.click(function() {
    if ($s3HelperRefreshBucketsBtn.hasClass('disabled')) {
        return;
    }

    $s3HelperRefreshBucketsBtn.addClass('disabled');
    $s3HelperRefreshBucketsSpinner.removeClass('hidden');

    var data = {
        keyId:  $s3HelperAccessKeyIdInput.val(),
        secret: $s3HelperSecretAccessKeyInput.val()
    };
    console.log(data);
    Craft.postActionRequest('aws-s3', data, function(response, textStatus) {
        $s3HelperRefreshBucketsBtn.removeClass('disabled');
        $s3HelperRefreshBucketsSpinner.addClass('hidden');

        if (textStatus == 'success') {
            if (response.error) {
                alert(response.error);
            }
            else if (response.length > 0) {
                var currentBucket = $s3HelperBucketSelect.val(),
                    currentBucketStillExists = false;

                refreshingS3Buckets = true;

                $s3HelperBucketSelect.prop('readonly', false).empty();

                for (var i = 0; i < response.length; i++) {
                    if (response[i].bucket == currentBucket) {
                        currentBucketStillExists = true;
                    }

                    $s3HelperBucketSelect.append('<option value="' + response[i].bucket + '" data-url-prefix="' + response[i].urlPrefix + '" data-region="' + response[i].region + '">' + response[i].bucket + '</option>');
                }

                if (currentBucketStillExists) {
                    $s3HelperBucketSelect.val(currentBucket);
                }

                refreshingS3Buckets = false;

                if (!currentBucketStillExists) {
                    $s3HelperBucketSelect.trigger('change');
                }
            }
        }
    });
});

$s3HelperBucketSelect.change(function() {
    if (refreshingS3Buckets) {
        return;
    }

    var $selectedOption = $s3HelperBucketSelect.children('option:selected');

    $('.volume-url').val($selectedOption.data('url-prefix'));
    $s3HelperRegion.val($selectedOption.data('region'));
});

var s3ChangeExpiryValue = function() {
    var parent = $(this).parents('.field'),
        amount = parent.find('.s3-expires-amount').val(),
        period = parent.find('.s3-expires-period select').val();

    var combinedValue = (parseInt(amount, 10) === 0 || period.length === 0) ? '' : amount + ' ' + period;

    parent.find('[type=hidden]').val(combinedValue);
};

$('.s3-expires-amount').keyup(s3ChangeExpiryValue).change(s3ChangeExpiryValue);
$('.s3-expires-period select').change(s3ChangeExpiryValue);
