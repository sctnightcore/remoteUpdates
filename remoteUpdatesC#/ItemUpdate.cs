using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Networking;

public class ItemUpdate : MonoBehaviour
{
    public string botname;
    private void Start()
    {
        botname = Camera.main.GetComponent<RemoteUpdates>().bot_real_name;
    }
    void LateUpdate ()
    {
        if (Input.deviceOrientation == DeviceOrientation.Portrait)
        {
            ChangeToLandscape();
        }
        if (Input.deviceOrientation == DeviceOrientation.LandscapeLeft || Input.deviceOrientation == DeviceOrientation.LandscapeRight)
        {
            ChangeToPortrait();
        }
    }
    void ChangeToPortrait()
    {
        GetComponent<LayoutElement>().preferredWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().minWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().flexibleWidth = Screen.currentResolution.width;
        GetComponent<RectTransform>().localScale = new Vector3(1f, 1f, 1f);
    }

    void ChangeToLandscape()
    {
        GetComponent<LayoutElement>().preferredWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().minWidth = Screen.currentResolution.width;
        GetComponent<LayoutElement>().flexibleWidth = Screen.currentResolution.width;
        GetComponent<RectTransform>().localScale = new Vector3(1f, 1f, 1f);
    }

    public void UseItem()
    {
        StartCoroutine(SendItemCommand());
    }

    IEnumerator SendItemCommand()
    {
        WWWForm form = new WWWForm();
        form.AddField("req_type", "save_command");
        form.AddField("name", Camera.main.GetComponent<RemoteUpdates>().bot_real_name);
        form.AddField("console_command", "is " + transform.name);

        UnityWebRequest www = UnityWebRequest.Post(PlayerPrefs.GetString("host_address") + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();
        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }
    }
}
