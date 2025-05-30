const categories = {
    'travel': 'Путешествия',
    'politics': 'Политика',
    'food': 'Еда',
    'media': 'Медиа',
}

function loadTasks() {
    fetch('databasePHP/get_posts.php')
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            const taskList = document.getElementById('postList')
            taskList.innerHTML = ""
            data.forEach((task) => {
                const listItem = document.createElement('li')
                const title = document.createElement('div')
                const user = document.createElement('div')
                const category = document.createElement('div')
                const content = document.createElement('div')
                const date = document.createElement('div')
                const link = document.createElement('a')


                taskList.appendChild(listItem)
                listItem.append(title)
                listItem.append(user)
                listItem.append(category)
                listItem.append(content)
                listItem.appendChild(date)
                listItem.append(link)

                listItem.classList.add("postItem")
                title.classList.add("postTitle")
                user.classList.add("postUser")
                user.classList.add("postUser")
                content.classList.add("postContent")
                date.classList.add("postDate")
                link.classList.add("postLink")

                title.innerHTML = task.title
                user.innerHTML = task.userID
                category.innerHTML = categories[task.category]
                content.innerHTML = task.content
                date.innerHTML = task.created_at
                link.href = `post.php?id=${task.id}`
                link.innerHTML = "Перейти на пост"

                if (task.isadmin == 1) {
                    const delBTN = document.createElement('button')
                    listItem.appendChild(delBTN)
                    delBTN.classList.add("postDelete")
                    delBTN.innerHTML = "Удалить Пост"
                    delBTN.addEventListener("click", function (e) {
                        deleteTask(task.id)
                    })
                }
            })
        })
}

function deleteTask(taskID) {
    confirm("Удалить пост?")
    fetch(`databasePHP/delete_page.php?id=${taskID}`)
        .then(() => {
            window.location.reload()
        })
        .catch((error) => {
            alert("Произошла ошибка")
        })
}

loadTasks()