# Assessment Gap-Closure Notes — Dream Pawn Shop

This file tracks evidence that can be shown during an assessment. It must be kept honest: a written example is not proof that it was executed, and a repository file is not proof that a deployed environment uses it.

## Safe workflow

- Work on `feat/assessment-gap-coverage`, not directly on `main`.
- Review changes in a pull request before merging.
- Run the project's test suite and frontend build in a local/dev environment.
- Never test destructive SQL against the production NeonDB database.
- Record actual test commands and outcomes only after they have been run.

## Current gaps to address

| Area | Current evidence / limitation | Safe next step |
|---|---|---|
| Technology evaluation | The repository identifies Laravel/PHP, PostgreSQL/NeonDB, Blade/Tailwind/Vite, but does not itself prove a formal migration from an older stack. | Keep a short decision record explaining needs, trade-offs, versions, and alternatives considered. Do not claim a migration unless one actually happened. |
| SQL stored procedure | Application logic is primarily implemented in Laravel services; a PostgreSQL procedure is not a substitute for those services. | Use `database/sql/assessment_postgresql_examples.sql` as a separate, explicitly invoked practice example. It is not an application migration. |
| SQL function and transactions | Schema scripts include PostgreSQL trigger/function patterns, but assessors may ask for a standalone function and commit/rollback evidence. | Practice the examples in a disposable PostgreSQL database and capture the actual result. |
| Debugging | PHPUnit feature tests and deployment logs can support the workflow, but only if the candidate can explain a real issue they diagnosed. | Keep a concise incident note: symptom, evidence, root cause, fix, regression test, and actual outcome. |
| Algorithm complexity | There is no formal Big-O report identified in the repository. | Analyze a specific method and its data size assumptions; do not assign complexity to database internals without evidence. |
| Multimedia | This project is a web catalog/loan workflow. HTML/CSS alone does not establish multimedia programming. | Only claim multimedia competency if a genuine media feature is implemented and tested. An item image upload/gallery is a possible product feature, but it needs a deliberate design and storage/privacy decision. |
| Static analysis and resource monitoring | A test suite or deployment log is not the same as static analysis or resource monitoring. | Add tools/workflows only when they can run reliably in CI and their results can be inspected. |

## PostgreSQL examples

See `database/sql/assessment_postgresql_examples.sql`.

- The file is not loaded by Laravel automatically.
- It uses PostgreSQL-specific syntax and should not be run through the SQLite PHPUnit test suite.
- The procedure and function definitions should be reviewed and tested in a disposable PostgreSQL database before they are presented as executed evidence.
- The procedure call is commented out to avoid accidentally archiving a real category.
- The trigger creation example is commented out because the application schema may already have a timestamp trigger.
