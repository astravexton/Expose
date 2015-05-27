(function () {
  $(".view-annotation").click(function (e) {
    e.preventDefault();

    var $annotation = $(this).parent("div");
    var data = JSON.parse($annotation.attr('data-content'));
    console.log(data);
    var html = "<br><table class=\"table table-bordered\">";

    if (data.categories == "") {
      data.categories = "<i>null</i>";
    }

    html += "<tr><td><b>time</b></td><td>" + data.time + "</td>";
    html += "<tr><td><b>sequence_number</b></td><td>" + data.sequence_number + "</td></tr>";
    html += "<tr><td><b>__user_id</b></td><td>" + data.__user_id + "</td></tr>";
    html += "<tr><td><b>categories</b></td><td>" + data.categories + "</td></tr>";
    html += "<tr><td><b>title</b></td><td>" + data.title + "</td></tr>";
    html += "<tr><td><b>text</b></td><td>" + data.text + "</td></tr>";

    html += "</table>";

    bootbox.alert(html);
  });

  $("form.new-annotation").submit(function (e) {
    e.preventDefault();

    var data = $(this).serialize();

    $.ajax({
      url: '/annotate',
      method: 'POST',
      data: data,
      success: function () {
        window.location.reload(true);
      }
    })
  })
})();