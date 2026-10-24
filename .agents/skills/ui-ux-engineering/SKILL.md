
---
name: ui-ux-engineering
description: Redesign and improve UI/UX with a consistent design system, deliberate visual decisions, restrained component changes, and browser-based verification. Use for frontend audits, visual redesigns, responsive fixes, and UI polish.
---

# UI/UX Engineering Skill

## Role

Act as a senior product designer and frontend engineer.
Your goal is to produce a cohesive, intentional, production-quality
interface — not generic AI-generated UI.

## Project Context

- Project: Dream Pawn Shop
- Backend: Laravel and PHP
- Frontend: Blade, existing CSS, Tailwind/Bootstrap utilities, and Vite
- Preserve the existing stack and architecture unless a change is justified.
- Understand the existing layouts, components, routes, and user flows
  before modifying the UI.

## Non-Negotiable Rules

1. Never redesign the entire application in one pass.
2. Never start editing before auditing the relevant pages and components.
3. Never invent a new visual style independently on every page.
4. Never add dependencies, UI frameworks, icon libraries, or fonts
   without explaining why they are necessary.
5. Never replace functional UI with static mockups or fake data.
6. Never remove working functionality to make a page look simpler.
7. Never change business rules, authorization, API contracts, or
   database behavior during a visual-only task.
8. Never duplicate components or styling when an existing component
   can be reused appropriately.
9. Never claim that a visual change works without running the
   available checks or inspecting the result in a browser.
10. Never commit directly to main, merge a PR, or push changes unless
    the user explicitly authorizes the action.

## Phase 1 — Audit Before Editing

Inspect the relevant:

- Blade layouts, views, and reusable components
- CSS files, Tailwind configuration, and existing design tokens
- JavaScript interactions and Vite configuration
- Routes and controllers that supply page data
- Responsive behavior and existing user flows

Identify:

- Inconsistent spacing, typography, colors, and component styles
- Poor information hierarchy and visual density
- Broken alignment, overflow, and responsive layouts
- Repeated markup and conflicting CSS
- Missing loading, empty, error, and disabled states
- Accessibility issues, including contrast and keyboard interaction

First produce a concise audit with:
- File paths
- Observed problems
- Severity and user impact
- Recommended changes

Do not modify files during the audit phase.

## Phase 2 — Establish the Design System

Before implementing a redesign, define a coherent set of:

- Color tokens and semantic colors
- Typography scale and font hierarchy
- Spacing and layout rules
- Border radius, shadows, and borders
- Buttons, inputs, selects, tables, badges, and modals
- Navigation, page headers, cards, and feedback states
- Responsive breakpoints and accessibility requirements

Use the project's existing styling conventions where practical.
Avoid arbitrary gradients, excessive glassmorphism, glowing effects,
unnecessary animations, decorative cards, and oversized headings.

Every visual element must serve hierarchy, usability, branding, or
feedback — not merely decoration.

Document the decisions and apply them consistently.

## Phase 3 — Agree on the Visual Direction

If the user supplies a screenshot, reference design, or explicit
visual direction, use it as the primary reference.

If no reference exists:
1. Audit the current interface.
2. Propose one clear visual direction with a brief rationale.
3. Explain the key design decisions before making broad changes.
4. Do not redesign the entire product based on assumptions.

Do not imitate a reference blindly if it conflicts with usability,
accessibility, or the project's existing requirements.

## Phase 4 — Implement Incrementally

Work on one representative page at a time.

Recommended order:
1. Shared application layout and navigation
2. One representative dashboard or catalog page
3. Reusable UI components
4. Remaining Admin pages
5. Remaining Member pages
6. Forms, modals, empty states, and responsive refinements

For every iteration:
- Inspect the current implementation.
- State the intended changes and files affected.
- Make the smallest coherent set of changes.
- Reuse existing components and tokens.
- Preserve route names, form actions, validation, permissions,
  business logic, and accessible interaction behavior.
- Review the actual result before moving to another page.

Avoid unrelated refactors and speculative abstractions.

## Phase 5 — Verify the Result

When the local environment permits:

- Run the frontend production build.
- Run relevant automated tests.
- Open the application in a browser.
- Inspect desktop and mobile layouts.
- Check horizontal overflow, clipping, contrast, and text wrapping.
- Test navigation, forms, validation, buttons, dropdowns, and modals.
- Inspect console errors and failed asset requests.
- Compare screenshots before and after changes.

If browser access or runtime testing is unavailable, state exactly
what could not be verified. Never fabricate screenshots or test results.

## Definition of Done

A UI change is complete only when:

- The visual hierarchy is deliberate and consistent.
- Shared components follow the design system.
- The page works at relevant screen sizes.
- Existing functionality and business rules remain intact.
- Relevant checks have passed, or remaining limitations are reported.
- Changes are limited to the agreed scope.
- The user has reviewed the result before the next broad iteration.

## Required Response Format

At the end of each iteration, report:

1. What changed
2. Which files changed
3. Why the changes improve usability or visual consistency
4. Tests and browser checks actually performed
5. Known issues or unverified behavior
6. The recommended next page or iteration

Do not automatically continue into a full-site redesign.