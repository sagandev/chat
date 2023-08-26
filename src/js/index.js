$(document).ready(function () {
    $.get('./src/get_name.php').done((data) => localStorage.setItem('bot_name', data));
    $(".bot_name").map(function () {
        this.innerHTML = localStorage.getItem('bot_name');
    })
})

async function extraReply(data) {
    const parsed = JSON.parse(data);
    let reply = parsed.reply;
    const date = new Date();
    if (parsed.reply.includes("{time}")) {
        const minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
        reply = parsed.reply.replace("{time}", date.getHours() + ":" + minutes);
    }
    if (parsed.reply.includes("{date}")) {
        reply = parsed.reply.replace("{date}", (date.getDate() < 10 ? ("0" + date.getDate()) : date.getDate()) + "." + (date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1)) + "." + date.getFullYear());
    }
    if (parsed.reply.includes("{day}")) {
        reply = parsed.reply.replace("{day}", ['Sunday', 'Monday', 'Tuestady', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()]);
    }
    if (parsed.reply.includes("{weather}")) {
        reply = parsed.reply.replace("{weather}", "<br><div class='d-flex flex-row gap-1'><input type='text' class='form-control form-control-sm rounded-2' name='city' placeholder='City name'><button type='button' class='btn btn-success rounded-2' id='enterCity'><i class='bi bi-check'></i></button></div>");
    }
    if (parsed.reply.includes("{name}")) {
        reply = parsed.reply.replace("{name}", localStorage.getItem('bot_name'));
    }
    return reply;
}
$(document).on("click", "#enterCity", async function () {
    const city = $("input[name='city']").val();
    if (!city) return;
    const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=c5384a9a6f71bb5f7cd46a48c6ecdc89`);
    const data = await response.json();
    $("#chat-window").append(`<div class='d-flex flex-row p-2 gap-3'><div class='d-flex align-items-center'><img src='src/img/chatbot.png' alt='Chatbot avatar' class='rounded-circle' style='width: 32px; height:32px;object-fit:cover;'></div><div class='d-flex flex-column'><div><span class='float-start ps-1'>${localStorage.getItem('bot_name')}</span></div><div class='p-2 px-0 rounded-2 bg-body-tertiary'><div class='d-flex flex-row gap-3 rounded-2 px-5 ps-3 py-2'><div class='d-flex flex-column gap-1 justify-content-center align-items-center'><img src='https://openweathermap.org/img/wn/${data.weather[0].icon}.png' alt='weather icon'><span>${Math.round(data.main.temp)}&#8451;</span></div><div class='d-flex flex-column gap-1'><div class='d-flex flex-row gap-3'><div class='d-flex flex-column gap-1'><span class='fw-bold'>Feels like</span><span>${Math.round(data.main.feels_like)}&#8451;</span></div><div class='d-flex flex-column gap-1'><span class='fw-bold'>Pressure <i class='bi bi-emoji-smile'></i></span><span>${data.main.pressure} hPa</span></div></div><div class='d-flex flex-row gap-3'><div class='d-flex flex-column gap-1'><span class='fw-bold'>Wind <i class='bi bi-wind'></i></span><span>${data.wind.speed} km/h</span></div><div class='d-flex flex-column gap-1'><span class='fw-bold'>Humidity <i class='bi bi-droplet'></i></span><span>${data.main.humidity}%</span></div></div></div></div></div></div></div>`).scrollTop($('#chat-window')[0].scrollHeight);

})
$("#chat").submit(function (e) {
    e.preventDefault();
    const msg = $(this).find("input[name='message']");
    if (msg.val()) {
        $("#chat-window").append(`<div class='d-flex flex-row p-2 gap-3 ms-auto'><div class='d-flex flex-column'><div><span class='float-end pe-1'>You</span></div><div class='p-1 px-2 rounded-2 bg-primary'><span>${msg.val()}</span></div></div><div class='d-flex align-items-center'><img src='src/img/user.png' alt='Chatbot avatar' class='rounded-circle' style='width: 32px; height:32px;object-fit:cover;'></div></div>`).scrollTop($('#chat-window')[0].scrollHeight);
        $.post("./src/message.php", { message: msg.val() }).done(async data => {
            const reply = await extraReply(data);
            $("#chat-window").append(`<div class='d-flex flex-row p-2 gap-3'><div class='d-flex align-items-center'><img src='src/img/chatbot.png' alt='Chatbot avatar' class='rounded-circle' style='width: 32px; height:32px;object-fit:cover;'></div><div class='d-flex flex-column'><div><span class='float-start ps-1'>${localStorage.getItem('bot_name')}</span></div><div class='p-1 px-2 rounded-2 bg-body-tertiary d-flex flex-column'><span>${reply}</span></div></div></div>`).scrollTop($('#chat-window')[0].scrollHeight);
        })
        $(this).find("input[name='message']").val(null);
    }

});

