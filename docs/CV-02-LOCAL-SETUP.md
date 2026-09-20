# CV-02 Local WordPress Setup

## Goal

Create a clean Local WordPress installation while keeping all custom theme source code under Git at:

```text
D:\Arya\chemventure-website
```

The Local WordPress installation itself remains outside Git.

## Recommended Local Site

Create a new site in Local with:

- Site name: `ChemVenture`
- Local domain: `chemventure.local`
- Environment: Preferred
- WordPress: latest stable version offered by Local

Use a strong administrator username and password. Do not use `admin` as the username.

## Theme Connection

The repository contains the theme at:

```text
D:\Arya\chemventure-website\wp-content\themes\chemventure
```

A Windows directory junction connects this folder to the WordPress theme directory inside Local.

For the common Local path:

```text
C:\Users\Admin\Local Sites\chemventure\app\public
```

run:

```cmd
rmdir /s /q "C:\Users\Admin\Local Sites\chemventure\app\public\wp-content\themes\chemventure" 2>nul
mklink /J "C:\Users\Admin\Local Sites\chemventure\app\public\wp-content\themes\chemventure" "D:\Arya\chemventure-website\wp-content\themes\chemventure"
```

If Local created the site in a different folder, replace the Local path above with the actual path shown by Local.

## WordPress Configuration

After the junction is created:

1. Start the site in Local.
2. Open WordPress Admin.
3. Go to **Appearance → Themes**.
4. Activate **ChemVenture Green Paints**.
5. Go to **Settings → Permalinks** and select **Post name**.
6. Open the front end and confirm the CV-02 foundation screen loads.

No page-builder or additional plugin is required for CV-02.

## Verification

The CV-02 foundation is successful when:

- the custom theme appears in WordPress Admin
- the theme activates without a PHP error
- the Green Paints logo appears in the header
- desktop and mobile navigation work
- the front page shows the CV-02 foundation message
- edits made under the Git repository theme folder immediately appear in Local

## Git Boundary

Commit only project source code and documentation.

Do not commit:

- WordPress core
- Local configuration
- uploads
- plugins
- databases
- cache
- passwords, API keys or environment secrets
