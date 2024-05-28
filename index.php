<html data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./src/style/index.css">
</head>

<body>
    <div class="container p-2 d-flex justify-content-center align-items-center h-100 max-vh-100 min-vw-100">
        <div class="rounded-2 d-flex flex-column h-100 align-items-start border border-1 chat-window">
            <div class="bg-dark-subtle p-2 rounded-top w-100 border-bottom d-flex justify-content-between align-items-center">
                <span class='fs-5'>Chat with <span class='bot_name'></span></span>
                <a href='dashboard.php' class='btn btn-dark'><i class="bi bi-box-arrow-in-right"></i></a>
            </div>
            <div class="p-2 h-25 w-100 flex-fill d-flex flex-column gap-3 overflow-auto" id="chat-window">
                <div class="d-flex flex-row p-2 gap-3">
                    <div class="d-flex align-items-center"><img src="src/img/chatbot.png" alt="Chatbot avatar" class="rounded-circle" style="width: 32px; height:32px;object-fit:cover;"></div>
                    <div class="d-flex flex-column">
                        <div>
                            <span class="float-start ps-1 bot_name"></span>
                        </div>
                        <div class="p-1 px-2 rounded-2 bg-body-tertiary">
                            <span>Hello! How can I do for you?</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 mt-auto w-100">
                <form class="d-flex flex-row gap-2 mb-0" id="chat">
                    <input type="text" class="form-control" name="message">
                    <button class="btn btn-primary rounded-2"><i class="bi bi-send"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src="./src/js/index.js"></script>
</body>

</html>