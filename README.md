# DevConnect - Social Network for Developers

DevConnect is a social network designed for developers to share technical knowledge, collaborate, and connect with others in the tech community.

## Key Features

- **User Profiles**: Add skills, projects, and link your GitHub or GitLab account.
- **Connections**: Send and manage connection requests.
- **Post Sharing**: Share technical content (articles, code snippets, etc.).
- **News Feed**: View posts from your connections and filter by technology.
- **Likes, Comments & Shares**: Engage with content and share posts.
- **Real-Time Notifications**: Get notified about new interactions.
- **Hashtags & Search**: Organize and search content with hashtags.

## Installation

1. Clone this repository:
    ```bash
    git clone https://github.com/AmineDevF/DevConnect.git
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Run the migrations:
    ```bash
    php artisan migrate
    ```

6. Start the development server:
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` to access the app.

## Contributing

To contribute:

1. Fork the repo.
2. Create a new branch for your feature.
3. Make your changes.
4. Submit a pull request.