# Entity-Relationship Diagram — Lembah Entry System

Generated from current migrations + Eloquent models. Laravel framework tables
(`sessions`, `cache`, `cache_locks`, `password_reset_tokens`) are omitted as
they are not part of the business domain.

```mermaid
erDiagram
    USERS {
        bigint user_id PK
        string name
        string role "default: Guard"
        string username "unique"
        string password
        string remember_token
    }

    EMPLOYEES {
        bigint employee_id PK
        string name "unique"
        string department
        string plate_number
    }

    STAFF {
        bigint staff_id PK
        string name
        string department
    }

    VISITORS {
        bigint visitor_id PK
        string name
        string ic_number
        string phone
        string company
    }

    VISITS {
        bigint visit_id PK
        bigint employee_id FK
        bigint user_id FK
        date visit_date
        datetime check_in_time
        datetime check_out_time
        string purpose
        string status "default: Pending"
        text remarks
    }

    VISIT_VISITOR {
        bigint id PK
        bigint visit_id FK
        bigint visitor_id FK
        string pass_number
    }

    VEHICLES {
        bigint vehicle_id PK
        string plate_number
        string vehicle_type
        enum owner_type "staff | visitor"
        bigint visit_id FK
        bigint attendance_id FK
    }

    ITEMS {
        bigint item_id PK
        bigint visit_id FK
        string item_name
        int quantity "default: 1"
        string remarks
    }

    ATTENDANCES {
        bigint attendance_id PK
        bigint employee_id FK
        bigint user_id FK
        datetime check_in_time
        datetime check_out_time
        string vehicle_plate
    }

    NOTIFICATIONS {
        bigint notification_id PK
        bigint user_id FK
        bigint visit_id FK
        string message
        string status "default: Unread"
    }

    MESSAGES {
        bigint message_id PK
        bigint sender_id FK
        bigint receiver_id FK
        text content
        boolean is_read
    }

    SUPPORT_REQUESTS {
        bigint support_id PK
        string username
        string type "default: Password Reset"
        string status "default: Pending"
    }

    USERS ||--o{ VISITS : "logs (user_id)"
    EMPLOYEES ||--o{ VISITS : "is host of"
    VISITS ||--o{ VISIT_VISITOR : "has"
    VISITORS ||--o{ VISIT_VISITOR : "has"
    VISITS ||--o{ VEHICLES : "has"
    VISITS ||--o{ ITEMS : "has"
    VISITS ||--o{ NOTIFICATIONS : "triggers"
    USERS ||--o{ NOTIFICATIONS : "receives"
    EMPLOYEES ||--o{ ATTENDANCES : "clocks"
    USERS ||--o{ ATTENDANCES : "logs (user_id)"
    ATTENDANCES ||--o{ VEHICLES : "has"
    USERS ||--o{ MESSAGES : "sends (sender_id)"
    USERS ||--o{ MESSAGES : "receives (receiver_id)"
```

## Notes

- **VISIT_VISITOR** is a many-to-many junction table between `VISITS` and
  `VISITORS`, carrying an extra `pass_number` attribute per pairing.
- **VEHICLES** is polymorphic-by-convention: a vehicle belongs to either a
  `VISIT` or an `ATTENDANCE`, distinguished by `owner_type` (`staff` |
  `visitor`). Both FKs are nullable and cascade-delete with their parent.
- `VISITS.employee_id` and `VISITS.user_id` are `nullOnDelete`; deleting the
  referenced employee/user does not delete the visit, only nulls the FK.
- `ATTENDANCES.employee_id` is `cascadeOnDelete`; `ATTENDANCES.user_id` is
  `nullOnDelete`.
- **STAFF** appears to be a legacy table — current attendance/visit flows use
  **EMPLOYEES** instead, and `STAFF` has no incoming foreign keys from active
  tables.
- **SUPPORT_REQUESTS** references `users.username` as a plain string column,
  not an enforced foreign key.
