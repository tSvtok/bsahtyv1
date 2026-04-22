# Missing Frontend Features / Enhancements

The following items are missing or require significant work to reach production quality:

## Architecture & State
- [x] **State Management (Pinia)**: Store for User Authentication, Profile data, and Active Chat.
- [x] **API Layer**: Axios/Fetch services for Laravel 12 backend integration.
- [ ] **Mock Service Worker (MSW)**: (Optional) To simulate the backend before integration.

## UI Components (Refactoring Needed)
- [x] **Sidebar Component**: Unify the sidebars used in Feed, Map, and Profile into a single reusable component.
- [x] **FeedCard / EventCard**: Break down complex page templates into smaller, testable components.
- [x] **Global Modals**: 
  - Create Event Modal
  - Ask Question Modal (Integrated into Post Modal)
  - Edit Profile Modal
- [x] **Skeleton Loaders**: For content loading states.

## Functional Logic
- [x] **Real Map Integration**: Replace static background in `MapPage.vue` with Leaflet or Google Maps.
- [x] **Chat Logic**: Implement message sending/receiving state in `ChatPage.vue`.
- [x] **Form Validation**: Integrate Vuelidate or VeeValidate for Login/Register/Create forms.
- [ ] **Image Uploads**: Logic for profile photos and post images.

## Polish & UX
- [ ] **Toast Notifications**: For success/error feedback.
- [ ] **Search Logic**: Implement client-side filtering for Events and Messages.
- [ ] **Responsive Navigation**: Mobile-friendly side drawer for the main menu.
