let errors = {
  password: false,
  passwordConf: false
};

function showAlert(type, text) {
  $("body").prepend(`<div class='alert alert-${type}' role='alert'>${text}</div>`)
  $(".alert").first().hide().fadeIn(200).delay(2000).fadeOut(1000, function () {
    $(this).remove();
  });
}


$(document).on("click", "button[name='edit']", function () {
  const rowId = this.id;
  const query = $(`#row_${rowId} td:eq(1)`).text();
  const reply = $(`#row_${rowId} td:eq(2)`).text();
  $("#editModal input[name='query']").val(query);
  $("#editModal input[name='reply']").val(reply);
  $("#editModal input[name='rowId']").val(rowId);
  $("#editModal").modal("show");
})

$(document).on("click", "button[name='delete']", function () {
  const rowId = this.id;
  $("#deleteModal input[name='rowId']").val(rowId);
  $("#deleteModal").modal("show");
})

$(document).on("click", "button[name='add']", function () {
  $("#addModal").modal("show");
})

$("#editModal button[name='sendEdit']").click(function () {
  $.post("./src/edit.php", { query: $("#editModal input[name='query']").val(), reply: $("#editModal input[name='reply']").val(), id: $("#editModal input[name='rowId']").val(), token: $("#editModal input[name='token']").val() }).done(async res => {
    const data = JSON.parse(res);
    if (data.success == true) {
      $("#editModal").modal("hide");
      showAlert('success', data.msg);
    } else {
      $("#editModal").modal("hide");
      showAlert('danger', data.msg);
    }
  })
})

$("#deleteModal button[name='deleteConf']").click(function () {
  $.post("./src/delete.php", { id: $("#deleteModal input[name='rowId']").val(), token: $("#deleteModal input[name='token']").val() }).done(async res => {
    const data = JSON.parse(res);
    if (data.success == true) {
      $("#deleteModal").modal("hide");
      showAlert('success', data.msg);
    } else {
      $("#deleteModal").modal("hide");
      showAlert('danger', data.msg);
    }
  })
})
$("#addModal button[name='addRecord']").click(function () {
  const query = $("#addModal input[name='query']").val();
  const reply = $("#addModal input[name='reply']").val();
  if (query.length < 2 || reply.length < 2) return $("#addModal .modal-body").append("<span class='text-danger'>You need to enter data</span>");
  $.post("./src/new_record.php", { query: query, reply: reply, token: $("#addModal input[name='token']").val() }).done(async res => {
    console.log(res)
    const data = JSON.parse(res);
    if (data.success == true) {
      $("#addModal").modal("hide");
      showAlert('success', data.msg);
    } else {
      $("#addModal").modal("hide");
      showAlert('danger', data.msg);
    }
  })
})

$("#password").on("input", function () {
  if (
    this.value.length < 2 ||
    $("#passwordConf").val() !== $("#password").val()
  ) {
    $("#password").addClass("is-invalid");
    errors.password = true;
  } else {
    $("#password").removeClass("is-invalid");
    $("#passwordConf").removeClass("is-invalid");
    errors.password = false;
  }
  if ($("#passwordConf").val() !== $("#password").val()) {
    $("#passwordConf").addClass("is-invalid");
    $("#passwordHelp")
      .text("Passwords are not identical")
      .removeClass("d-none");
  } else {
    $("#passwordHelp").addClass("d-none");
  }

  if (errors.password) $("#editPassword").prop("disabled", true);
  else $("#editPassword").prop("disabled", false);
});
$("#passwordConf").on("input", function () {
  if (
    this.value.length < 2 ||
    $("#passwordConf").val() !== $("#password").val()
  ) {
    $("#passwordConf").addClass("is-invalid");
    $("#password").addClass("is-invalid");
    errors.passwordConf = true;
  } else {
    $("#password").removeClass("is-invalid");
    $("#passwordConf").removeClass("is-invalid");
    $("#passwordHelp").addClass("d-none");
    errors.passwordConf = false;
    errors.password = false;
  }

  if ($("#passwordConf").val() !== $("#password").val()) {
    $("#passwordHelp")
      .text("Passwords are not identical")
      .removeClass("d-none");
  }

  if (errors.password) $("#editPassword").prop("disabled", true);
  else $("#editPassword").prop("disabled", false);
});

$("#change_password").submit(function (e) {
  e.preventDefault();
  const password = $(this).find("input[name='password']").val();
  const passwordConf = $(this).find("input[name='passwordConf']").val();

  if (!errors.password && !errors.passwordConf) {
    $.post('./src/password.php', { password: password, password_conf: passwordConf, token: $(this).find("input[name='token']").val() }).done((res) => {
      const data = JSON.parse(res);
      if (data.success == true) {
        showAlert('success', data.msg);
      } else {
        showAlert('danger', data.msg)
      }
    })
  }
})
$("#edit_bot_name").submit(function (e) {
  e.preventDefault();
  const botName = $(this).find("input[name='botName']").val();
  $.post('./src/bot_settings.php', { bot_name: botName, token: $(this).find("input[name='token']").val() }).done((res) => {
    const data = JSON.parse(res);
    if (data.success == true) {
      showAlert('success', data.msg);
    } else {
      showAlert('danger', data.msg)
    }
  })
})
