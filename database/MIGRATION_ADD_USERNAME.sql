# DATABASE MIGRATION - Add Username Field

## Instructions

To add username support to your existing system, run this SQL query:

```sql
-- Add username column to users table (if not already present)
ALTER TABLE users ADD COLUMN username VARCHAR(100) UNIQUE AFTER email;

-- Create index for username for faster login queries
CREATE INDEX idx_username ON users(username);
```

## Notes

- This adds a new `username` field to the users table
- Username will be unique (no two users can have the same username)
- Users can login with EITHER username OR email
- This is backward compatible - existing accounts can still login with email
- New registrations can provide a username

## After Running Migration

1. Update registration form to include username field
2. Update login form to use username field
3. Update login handler to check username OR email
4. Users can now login with username instead of email
