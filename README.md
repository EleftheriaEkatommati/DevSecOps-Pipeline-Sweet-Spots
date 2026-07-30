# DevSecOps Pipeline with DVWA

This repository demonstrates a DevSecOps workflow for the open-source DVWA application. It is designed for educational use and shows how to combine Git hooks, container-based security checks, and a CI/CD pipeline to scan for secrets, code issues, configuration problems, and runtime exposure.

The project intentionally includes vulnerable components in DVWA so that security tools can be tested in a controlled environment.

## 1. Project purpose

This assignment-style repository covers the following DevSecOps topics:

- Local Git hooks for fast security checks before commit and push
- A CI/CD workflow that runs static and dynamic scans
- Container-based execution of security tools
- Documentation of the workflow and the files involved

> Warning: DVWA is intentionally insecure. Use it only in a local or isolated lab environment.

## 2. Repository overview

The repository contains:

- DVWA-master/: the DVWA application source and its Docker configuration
- local-wehook-scripts/: Git hook scripts for local pre-commit and pre-push checks
- .github/workflows/devsecops.yml: the CI/CD workflow for static and dynamic checks
- endpoints.txt: endpoints used for dynamic SQL injection testing
- urls.txt: additional URLs for manual inspection or testing
- vulnerabilities_summary.txt: summary of the intentionally introduced security issues

## 3. Prerequisites

Before using the project, install the following:

- Git
- Docker and Docker Compose
- A Unix-like shell (Linux/macOS terminal) or WSL on Windows

Verify that Docker is working:

```bash
docker --version
docker compose version
```

## 4. Running the DVWA application locally

The DVWA application is located in the DVWA-master folder.

### Start the container

```bash
cd DVWA-master
docker compose up -d
```

The application will be available at:

- http://127.0.0.1:4280

### Stop the container

```bash
cd DVWA-master
docker compose down
```

### Useful container commands

```bash
docker compose ps
docker compose logs -f
docker compose restart
```

## 5. Git workflow and Git hooks

The repository provides local hook scripts that can be installed into the Git hooks directory.

### Install the hooks

From the repository root:

```bash
mkdir -p .git/hooks
cp local-wehook-scripts/pre-commit .git/hooks/pre-commit
cp local-wehook-scripts/pre-push .git/hooks/pre-push
chmod +x .git/hooks/pre-commit .git/hooks/pre-push
```

### What the hooks do

- Pre-commit hook:
  - checks whether Docker is running
  - runs Gitleaks inside a Docker container to detect hardcoded secrets

- Pre-push hook:
  - checks whether Docker is running
  - runs PHPStan inside a Docker container for basic static analysis

These checks are intended to provide fast local feedback before changes are pushed to the remote repository.

### Manual hook execution

You can also run the checks manually if needed:

```bash
./local-wehook-scripts/pre-commit
./local-wehook-scripts/pre-push
```

## 6. CI/CD workflow

The CI/CD workflow is defined in [.github/workflows/devsecops.yml](.github/workflows/devsecops.yml). It is implemented with GitHub Actions, which is an equivalent CI/CD solution to Jenkins for this assignment.

The workflow runs on push and pull request to the main branches and includes the following stages:

1. Secret scanning with Gitleaks
2. Static analysis with Semgrep
3. Repository and configuration scanning with Trivy
4. Container image scanning with Trivy
5. Dynamic port/service scan with Nmap
6. Dynamic application security testing with OWASP ZAP
7. SQL injection testing with sqlmap using the endpoints listed in endpoints.txt

### How to view the results

When the workflow runs in GitHub, the results are published as workflow artifacts and summarized in the job summary page.

## 7. Security tools used

The pipeline uses the following tools:

- Gitleaks: detects hardcoded secrets and credentials
- Semgrep: performs static application security testing (SAST)
- Trivy: scans files and container images for known vulnerabilities
- Nmap: checks open ports and exposed services on the running container
- OWASP ZAP: performs dynamic application security testing against the running DVWA instance
- sqlmap: tests predefined endpoints for SQL injection behavior
- PHPStan: performs basic static analysis for PHP code quality

## 8. Dynamic testing targets

The dynamic tests use the following files:

- [endpoints.txt](endpoints.txt): endpoints used for SQL injection testing
- [urls.txt](urls.txt): URLs for manual verification or additional testing
- OWASP ZAP is configured in [.github/workflows/devsecops.yml](.github/workflows/devsecops.yml) as a dynamic scan step for the running application

Example:

```bash
cat endpoints.txt
cat urls.txt
```

## 9. File guide

| File | Purpose |
| --- | --- |
| [README.md](README.md) | Main documentation for the project and assignment workflow |
| [endpoints.txt](endpoints.txt) | Target endpoints for dynamic SQL injection testing |
| [urls.txt](urls.txt) | Additional URLs used for testing and inspection |
| [vulnerabilities_summary.txt](vulnerabilities_summary.txt) | Summary of the intentionally included security issues |
| [local-wehook-scripts/pre-commit](local-wehook-scripts/pre-commit) | Local pre-commit hook for secret scanning |
| [local-wehook-scripts/pre-push](local-wehook-scripts/pre-push) | Local pre-push hook for static analysis |
| [.github/workflows/devsecops.yml](.github/workflows/devsecops.yml) | CI/CD pipeline definition |
| [DVWA-master/Dockerfile](DVWA-master/Dockerfile) | Container build file for the DVWA application |
| [DVWA-master/compose.yml](DVWA-master/compose.yml) | Docker Compose configuration for DVWA and its database |

## 10. Notes for the assignment

This repository is suitable for the assignment because it demonstrates:

- static analysis of source code
- dynamic analysis of a running application
- container-based execution of tools
- documentation of the workflow and the security findings
- use of an open-source application (DVWA)

The intentionally introduced weaknesses are for educational purposes only and should remain inside a controlled lab environment.

## 11. Quick start summary

```bash
# 1. Clone and enter the repository
git clone <repository-url>
cd DevSecOps-Pipeline-Sweet-Spots

# 2. Install Git hooks
mkdir -p .git/hooks
cp local-wehook-scripts/pre-commit .git/hooks/pre-commit
cp local-wehook-scripts/pre-push .git/hooks/pre-push
chmod +x .git/hooks/pre-commit .git/hooks/pre-push

# 3. Start DVWA locally
cd DVWA-master
docker compose up -d

# 4. Open the application
# http://127.0.0.1:4280
```