# STATUS — 001-mygit-first (학생 상담 시스템)

작성: 2026-06-14 (자동 포트폴리오 스윕). 브랜치: `claude/sweep-2026-06-13`.

## 목적

컴퓨터공학과 학생 상담 기록을 입력하고 학번으로 조회하는 간단한 웹 앱이다.
저장소 이름(`001-mygit-first`)과 빈 README로 보아 첫 Git 연습용 학습 프로젝트로 추정된다(추정).

## 프로젝트 유형

정적 프론트엔드(HTML/CSS/JS) + 미연결 PHP/MySQL 백엔드. 빌드 도구·패키지 매니페스트·테스트 없음.

## 현재 상태: 동작하는 것 vs 안 되는 것

### 동작한다

- `index.html` + `style.css`는 자체 완결형 프론트엔드다. 브라우저로 열면
  상담 입력·저장·학번 검색이 모두 동작한다. 데이터는 브라우저 **localStorage**에 저장된다.
  (코드 정독으로 확인. `submit` 핸들러가 `saveRecord()`로 localStorage에 push하고
  `searchRecords()`가 학번으로 필터링한다.)

### 동작하지 않는다 / 미완성

- **프론트엔드와 PHP 백엔드가 분리되어 있다.** `index.html`의 폼은 `process.php`로
  POST하지 않는다(`fetch`/`action` 호출 없음, localStorage만 사용). 즉 `process.php`,
  `database.sql`, `config.php`는 현재 UI 흐름에서 전혀 호출되지 않는다.
- `config.php`가 사실상 비어 있다(공백 1바이트). `process.php`는 `require_once 'config.php'`
  후 `$conn`(mysqli)을 사용하므로, 단독 실행 시 `$conn` 미정의로 치명적 오류가 난다(코드 기준 추론).
- README가 제목만 있는 빈 파일이었다 → 이번 스윕에서 내용 보강함.

## 테스트 / 빌드 증거

- 테스트 프레임워크·매니페스트 없음 → 자동 테스트 `na`.
- `php`가 이 환경에 설치되어 있지 않아(`php not found`, exit 127) `php -l` 구문 검사를
  수행하지 못함 → PHP 구문 검증은 **unverified**.
- 정적 프론트엔드는 빌드 단계가 없으며 브라우저로 직접 열어 동작(코드 정독으로 확인).
  자동 스윕에서는 브라우저 스모크 테스트를 띄우지 않았다.

## 끝내기 위한 구체적 남은 작업

1. **프론트엔드↔백엔드 연결 결정.** 둘 중 하나를 고른다.
   - (A) localStorage 단독 사용으로 확정하고 `process.php`·`config.php`·`database.sql` 제거 또는 보관 명시.
   - (B) PHP/MySQL 백엔드 사용. 이 경우 아래 2~4 수행.
2. `config.php` 채우기: mysqli 연결 코드 작성(예: `$conn = new mysqli(host, user, pass, 'student_counseling');`).
   **비밀번호는 커밋 금지** — 환경변수/별도 비추적 파일로 분리.
3. `index.html`의 submit 핸들러를 `fetch('process.php', { method:'POST', body: formData })`로 교체하고,
   응답 JSON(`success`/`message`)을 화면에 반영.
4. 조회(`searchRecords`)도 서버 조회용 엔드포인트를 새로 만들어 연결(현재 조회용 PHP 없음).
5. (B 경로) `process.php`의 `insert_id` 처리 검토: 신규 INSERT가 아닌 `ON DUPLICATE KEY UPDATE`
   경로에서는 `insert_id`가 0이 될 수 있어 기존 학생의 PK 조회 로직 추가 필요(미검증, 코드 기준 우려).
6. 입력값 검증·XSS 방어: 검색 결과 렌더링이 `innerHTML`로 사용자 입력을 그대로 삽입한다
   (`record.content` 등) → 저장형 XSS 우려. `textContent` 또는 이스케이프 권장(미검증, 코드 기준 우려).

## 보안 메모 (미검증, 코드 정독 기준)

- 검색 결과 렌더링이 사용자 입력을 `innerHTML` 템플릿 리터럴로 직접 삽입 → XSS 가능성.
  현재 localStorage 단일 사용자 범위라 영향은 제한적이나, 백엔드 연결 시 반드시 처리.
- `config.php`에 DB 자격증명을 넣게 되면 절대 평문 커밋하지 말 것.

## 책/논문 가능성

없음. 소규모 학습용 CRUD 웹앱으로 연구·서술형 산출물 소재가 아니다.

---

## English summary

**Purpose:** A small CS-department student-counseling web app (input + lookup by
student ID), likely a first Git practice project.

**Type:** Static HTML/CSS/JS frontend + an unconnected PHP/MySQL backend. No build
tooling, no manifest, no tests.

**Works:** `index.html` + `style.css` form a self-contained frontend that saves and
searches counseling records via browser **localStorage**; verified by code reading.

**Does not work / incomplete:** The frontend and PHP backend are disconnected — the
form never POSTs to `process.php` (localStorage only), so `process.php`,
`database.sql`, and `config.php` are unused by the UI. `config.php` is empty, so
`process.php` would fatal on an undefined `$conn` (inferred from code).

**Test/build evidence:** No test framework or manifest (test = na). `php` is not
installed in this environment (`php not found`), so `php -l` syntax checks were
**not** performed (PHP syntax unverified). The static frontend has no build step;
no browser smoke test was run in the sweep.

**Remaining work:** Decide localStorage-only vs PHP backend; if backend, fill
`config.php` with a mysqli connection (no committed secrets), wire the form to
`fetch('process.php')`, add a server-side lookup endpoint, review the
`insert_id`/`ON DUPLICATE KEY UPDATE` path, and fix the `innerHTML` XSS exposure in
search rendering.

**Book/paper potential:** None — a small learning CRUD app.

**This sweep changed:** Filled the empty `README.md` and added this `STATUS.md`.
No code logic was modified.
