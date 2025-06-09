:navigation-title: Distribution

..  include:: /Includes.rst.txt
..  _docker-image-distribution-overview:

===============================================
Distributing TYPO3 Docker images for deployment
===============================================

..  include:: /Administration/Docker/Production/_Experimental.rst.txt

When deploying a TYPO3 site using Docker, your custom site package,
extensions, and configuration are typically bundled into a Docker image.
Before the container can be run on a production server, that image needs to
be **distributed** to the server — usually via a container registry or
manual transfer.

..  contents:: Table of contents

..  _docker-image-distribution-hub:

Choosing a secure Docker image distribution hub
===============================================

This guide focuses specifically on **secure image distribution**,
which is a critical step in the overall deployment process. Running a
container and configuring a production environment (e.g., web server,
database, volumes) are considered part of full deployment and are not
covered here.

..  _docker-image-distribution-dockerhub:

Option 1: Docker Hub (private repository)
-----------------------------------------

Docker Hub provides private repositories, which allow you to push and pull
images without exposing them publicly.

To ensure your TYPO3 Docker image remains private, follow these steps:

#.  Create a private repository using the Docker Hub web interface:

    1.  Visit https://hub.docker.com/repositories
    2.  Click "Create Repository"
    3.  Set the name (e.g. `your-image`) and make sure **"Private"** is selected

#.  Log in to Docker Hub, tag and push your image

    .. code-block:: bash

        docker login
        docker tag your-image yourusername/your-image:tag
        docker push yourusername/your-image:tag

**Note:** Free Docker Hub accounts allow only a limited number of private
repositories. A paid plan may be required for production use.

..  _docker-image-distribution-ghcr:

Option 2: GitHub Container Registry (GHCR)
------------------------------------------

If your TYPO3 project's source code is stored in a GitHub repository,
you can use the GitHub Container Registry (`ghcr.io`) to securely store
Docker images.

**Steps to distribute a TYPO3 image via GHCR:**

1.  Authenticate using a GitHub personal access token.

    ..  code-block:: bash

        # echo YOUR_GITHUB_PAT | docker login ghcr.io -u YOUR_GITHUB_USERNAME --password-stdin

    Replace:

    *   `YOUR_GITHUB_PAT` with your personal access token
    *   `YOUR_GITHUB_USERNAME` with your GitHub username

2.  Tag and Push Your Image

    ..  code-block:: bash

        # Tag your Docker image:
        docker tag your-image ghcr.io/yourusername/your-image:tag

        #Push the image
        docker push ghcr.io/yourusername/your-image:tag

**Tip:** GHCR integrates well with GitHub Actions for CI/CD pipelines.

..  _docker-image-distribution-gitlab:

Option 3: GitLab Container Registry
-----------------------------------

If your TYPO3 project's source code is managed in GitLab, you can use the
GitLab Container Registry to store Docker images alongside your project.

This registry is built into GitLab and integrates with GitLab CI/CD,
allowing you to build, tag, and push images during your deployment pipeline.

**Steps to distribute a TYPO3 image via GitLab Registry:**

..  code-block:: bash

    # Authenticate with GitLab
    docker login registry.gitlab.com

    # Tag your image using the GitLab project namespace
    docker tag your-image registry.gitlab.com/your-namespace/your-project/your-image:tag

    # Push the image
    docker push registry.gitlab.com/your-namespace/your-project/your-image:tag

**Note:** You can manage image visibility and permissions through your GitLab
project settings. This approach is ideal for teams already using GitLab
as part of their development and deployment process.

..  _docker-image-distribution-self-hosted:

Option 4: Self-hosted Docker registry
-------------------------------------

Running your own Docker registry gives you full control over where and how
images are stored and accessed.

..  code-block:: bash

    # Start a local registry
    docker run -d -p 5000:5000 --name registry registry:2

    # Tag and push your image
    docker tag your-image localhost:5000/your-image
    docker push localhost:5000/your-image

**Note:** For production use, configure SSL encryption and authentication.

..  _docker-image-distribution-cloud:

Option 5: Cloud provider registries
-----------------------------------

If you are deploying TYPO3 to a major cloud provider, consider using their
managed container registries:

-   **Amazon ECR (Elastic Container Registry)**
-   **Google Artifact Registry**
-   **Azure Container Registry**

These registries offer high security, scalability, and tight integration
with their respective cloud services and IAM systems.

..  _docker-image-distribution-summary:

Summary: Choosing the right distribution method
-----------------------------------------------

TYPO3 Docker images must be securely transferred to the target environment
before they can be deployed and run. This guide outlines secure and
practical methods for distributing your TYPO3 image.

Choose the method that best fits your infrastructure, compliance needs,
and workflow. All the methods described here are compatible with TYPO3 projects
and can be part of modern DevOps pipelines.
..  _docker-image-distribution-github:

Automatically build and tag Docker images in CI/CD pipelines
============================================================

It is common practice to build, tag, and distribute Docker images as part of
a CI/CD pipeline. The tools used for this (such as GitHub Actions or GitLab CI)
and the general principles are similar across platforms.

..  seealso::

    *   `CI/CD: Automatic deployment for TYPO3 Projects
        <https://docs.typo3.org/permalink/t3coreapi:ci-cd-for-typo3-projects>`_

Depending on the container registry you choose (see:
https://docs.typo3.org/permalink/t3coreapi:docker-image-distribution-hub)
and the CI/CD tool in use, the scripts will differ accordingly.

In the TYPO3 documentation project, we currently use a GitHub Actions workflow
to build and publish our Docker image to a public Docker Hub repository:

*   `site-introduction/.github/workflows/docker-publish.yml
    <https://github.com/TYPO3-Documentation/site-introduction/blob/main/.github/workflows/docker-publish.yml>`_

To use this setup, you must provide your Docker Hub credentials as secrets:

*   Create an access token on Docker Hub:
    https://docs.docker.com/security/for-developers/access-tokens/
*   Add your username and token in GitHub as secrets:
    https://docs.github.com/en/actions/security-guides/encrypted-secrets

..  note::
    Are you using a different method to distribute your Docker image
    automatically? Use the "Edit on GitHub" button to contribute your approach
    to this documentation.
